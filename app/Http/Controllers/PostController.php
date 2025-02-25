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
                ->addColumn('action', function($row){
                    return '<a href="/posts/'.$row->id.'/edit" class="btn btn-primary">Edit</a>';
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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
