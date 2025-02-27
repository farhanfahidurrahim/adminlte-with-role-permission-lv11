<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $posts = Post::with('category', 'createdBy', 'updatedBy')->orderBy('name', 'asc');

            // Apply Date Filter
            if (!empty($request->date_from) && !empty($request->date_to)) {
                $posts->whereBetween('date', [$request->date_from . ' 00:00:00', $request->date_to . ' 23:59:59']);
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
                    return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger deleteData" data-id="' . $row->id . '" data-url="' . $deleteUrl . '" title="Delete"><i class="fas fa-trash"></i></button>';
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
            'status' => 'required|in:published,draft',
        ]);

        Post::create([
            'name' => ucwords(strtolower($request->name)),
            'category_id' => $request->category_id,
            'date' => $request->date ? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString(),
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
