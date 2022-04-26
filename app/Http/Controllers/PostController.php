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
    public function index(Request $request)
    {
        $state_name = $request->query('state') ?? 'pending';
        $posts = Post::where('state', config('post.'.$state_name))->paginate(config('post.post_per_page'));
        return view('posts.index', compact('posts'));
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $state_name = $request->get('state') ??  'pending';
            $posts = $posts = Post::where('state', config('post.' . $state_name))->paginate(config('post.post_per_page'));
            return view('posts.pagination', compact('posts'))->render();
        }
    }
    //approve a post (change the state of a post from pending to public)
    function approve(Request $request)
    {
        $post = Post::find($request->id);
        if ($post) {
            $post->state = config('post.public');
            $post->save();
            return redirect()->back()->with('success', 'Post saved.');
        }
        return redirect()->back()->with('failure', 'This post does not exist');
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
            'image'=>''
        ]);
        $file = $request->file('image');
        if ($file) {
            $file_name = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('storage/uploads/image'), $file_name);
            $post['image'] = $file_name;
        }
        $post->save();

        return redirect()->to(route('admin.posts.index'))->with('success', 'Post saved.');
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

        $file = $request->file('image');
        if ($file) {
            $file_name = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/image'), $file_name);
            $post['image'] = $file_name;
        }

        $post->save();
        return redirect()->to(route('admin.posts.index'))->with('success', 'Post updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // $post->delete();
        $post->state = config('post.cancel');
        $post->save();
        return redirect()->back()->with('success', 'Post removed.');  // -> resources/views/stocks/index.blade.php
    }
}
