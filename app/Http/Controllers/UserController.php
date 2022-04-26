<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $state_name = $request->query('state') ?? 'pending';
        // dd($state_name);
        // Log::error($state_name);    
        // error_log($request->query('state'));
        $users = User::where('state', config('user.'.$state_name))->paginate(config('user.user_per_page'));
        return view('users.index', compact('users'));
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->get('type'));
            error_log($request->get('state'));
            $state_name = $request->get('state') ??  'pending';
            // $posts = Post::where('type','=',$type)->paginate(config('post.post_per_page'));
            // error_log($posts->);
            $users = User::where('state', config('user.'.$state_name))->paginate(config('user.user_per_page'));

            // $posts = Post::paginate(config('post.post_per_page'));
            return view('users.pagination', compact('users'))->render();
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $state_name = $request->get('state');
        if($user)
        {
            $user->state = config('user.'.$state_name);
            $user->save();
            return redirect()->back()->with('success', 'User updated.');
        }
        return redirect()->back()->with('failure','User not found.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        if($user)
        {
            $user->state = config('user.cancelled');
            $user->save();
        }
        return redirect()->back()->with('success', 'User removed.');  // -> resources/views/stocks/index.blade.php
    }
}
