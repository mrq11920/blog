<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all();
        // $posts = DB::table('posts')->paginate(15);
        $posts = Post::paginate(config('post.post_per_page'));

        return view('posts.index', compact('posts'));
    }

    function fetch_data(Request $request)
    {
        // dd('fsdfs');
        if ($request->ajax()) {
            $posts = Post::paginate(config('post.post_per_page'));
            return view('posts.pagination', compact('posts'))->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = new Post([
            'title' => $request->get('title'),
            'content' => $request->input('content'),
            'is_published' => $request->get('is_published')
        ]);


        // $content = $request->input('content-ckeditor');

        $post->save();

        return redirect('/posts')->with('success', 'Post saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->title = $request->title;
        $post->content = $request->content;
        $post->is_published =  $request->get('is_published');

        $post->save();
        return redirect('/posts')->with('success', 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/posts')->with('success', 'Post removed.');  // -> resources/views/stocks/index.blade.php
    }
}
