<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Laravel\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $posts = Post::with('category', 'createdBy', 'updatedBy')->orderBy('name', 'asc');

            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            // Apply Date Filter
            if (!empty($dateFrom) && !empty($dateTo)) {
                $posts->whereBetween('date', [$dateFrom, $dateTo]);
            } elseif ($dateFrom) {
                $posts->whereDate('date', '>=', $dateFrom);
            } elseif ($dateTo) {
                $posts->whereDate('date', '<=', $dateTo);
            }

            return DataTables::of($posts)
                ->addIndexColumn()
                ->editColumn('date', function ($post) {
                    return Carbon::parse($post->date)->format('d M Y');
                })
                ->editColumn('category_id', function ($post) {
                    return $post->category? $post->category->name : 'N/A';
                })
                ->filterColumn('category_id', function ($query, $keyword) {
                    $query->whereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
                })
                ->editColumn('created_by', function ($post) {
                    return $post->createdBy? $post->createdBy->name : 'N/A';
                })
                ->editColumn('updated_by', function ($post) {
                    return $post->updatedBy? $post->updatedBy->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('posts.show', $row->id);
                    $editUrl = route('posts.edit', $row->id);
                    $deleteUrl = route('posts.destroy', $row->id);
                    $pdfDownloadUrl = route('pdfDownload', ['modelType' => 'post', 'id' => $row->id]);

                    return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger deleteData" data-id="' . $row->id . '" data-url="' . $deleteUrl . '" title="Delete"><i class="fas fa-trash"></i></button>
                        <a href="' . $pdfDownloadUrl . '" class="btn btn-sm btn-primary" title="Download PDF"><i class="fas fa-download"></i></a>';
                })
                ->make(true);
        }

        return view('pages.post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:posts',
            'category_id' => 'required|exists:categories,id',
            'date' => 'nullable|date|before_or_equal:today',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:2048',
            'document' => 'nullable|mimes:pdf,docx,doc|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        $imageName = NULL;
        if ($request->hasFile('image')) {
            $uploadImage = $request->file('image');
            $image = Image::read($uploadImage)->resize(300, 200);
            $imageName = uniqid() . '.' . $uploadImage->getClientOriginalExtension();

            $imageDirectory = storage_path('app/public/images/post/');
            if (!is_dir($imageDirectory)) {
                mkdir($imageDirectory, 0755, true);
            }
            $image->save($imageDirectory . $imageName);
        }

        $documentName = null;
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentName = uniqid() . '.' . $document->getClientOriginalExtension();

            $documentDirectory = storage_path('app/public/documents/post/');
            if (!is_dir($documentDirectory)) {
                mkdir($documentDirectory, 0755, true);
            }
            $document->move($documentDirectory, $documentName);
        }

        Post::create([
            'name' => ucwords(strtolower($request->name)),
            'date' => $request->date ? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString(),
            'category_id' => $request->category_id,
            'image' => $imageName,
            'document' => $documentName,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('pages.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();

        return view('pages.post.edit', compact('post' ,'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:posts,name,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:published,draft',
        ]);

        $post->update([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'status' => $request->input('status'),
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['success' => 'Post deleted successfully!']);
    }
}
