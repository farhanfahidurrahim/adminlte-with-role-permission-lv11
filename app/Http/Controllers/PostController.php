<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $posts = Post::query();

            return DataTables::of($posts)
                ->editColumn('category_id', function ($post) {
                    return $post->category? $post->category->name : 'N/A';
                })
                ->editColumn('created_by', function ($post) {
                    return $post->createdBy? $post->createdBy->name : 'N/A';
                })
                ->editColumn('updated_by', function ($post) {
                    return $post->updatedBy? $post->updatedBy->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('posts.edit', $row->id);
                    $deleteUrl = route('posts.destroy', $row->id);
                    return '<a href="' . $editUrl . '" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger deleteData" data-id="' . $row->id . '" data-url="' . $deleteUrl . '">Delete</button>';
                })
                ->addIndexColumn()
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
            'status' => 'required',
        ]);

        Post::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
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
