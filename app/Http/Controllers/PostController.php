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
        $posts = Post::where('state', config('post.public'))->paginate(config('post.post_per_page'));
        // $type = 1;
        // $posts = DB::table('posts')->select('*')->where('state','=',$type)->get()->paginate(config('post.post_per_page'));
        // $query = DB::select('select * from posts where state = ?', [1]);
        // $posts = new Paginator($query, $maxPage);
        return view('posts.index', compact('posts'));
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->get('type'));
            $state_name = $request->get('state') ??  config('post.default_state_name');
            // $posts = Post::where('type','=',$type)->paginate(config('post.post_per_page'));
            // error_log($posts->);
            $posts = $posts = Post::where('state', config('post.'.$state_name))->paginate(config('post.post_per_page'));

            // $posts = Post::paginate(config('post.post_per_page'));
            return view('posts.pagination', compact('posts'))->render();
        }
    }
    // return posts where state = 2 (pending)
    function pending(Request $request)
    {
        $posts = Post::where('state', config('post.pending'))->paginate(config('post.post_per_page'));
        return view('posts.pending', compact('posts'));
    }
    // return posts where state = 3 (cancel)
    function cancel(Request $request)
    {
        $posts = Post::where('state', config('post.cancel'))->paginate(config('post.post_per_page'));
        return view('posts.cancel', compact('posts'));
    }

    //aprrove a post (change the state of a post from pending to public)
    function approve(Request $request)
    {
        // dd('approve');
        // dd($request->id);
        $post = Post::find($request->id);
        if ($post) {
            $post->state = config('post.public');
            $post->save();
            return redirect('/posts')->with('success', 'Post saved.');
        }
        return redirect('/posts')->with('failure', 'This post does not exist');
        // return redirect()->back();
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
            // 'state' => $request->get('is_published')
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
        // $post->delete();
        $post->state = config('post.cancel');
        $post->save();
        return redirect('/posts')->with('success', 'Post removed.');  // -> resources/views/stocks/index.blade.php
    }
}
