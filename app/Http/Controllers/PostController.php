<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Post;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$posts = DB::table('posts')
            ->leftJoin('profiles','profiles.user_id','=','posts.user_id')
            ->leftJoin('users','posts.user_id','=','users.id')
            ->get();
        return $posts;
        //dd($posts);
        //return view('welcome');*/
        $posts = Post::with('user')
                ->orderBy('created_at','DESC')
                ->get();
        //dd($posts);
        //return view('welcome')
        return $posts;

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
        //dd("aada");
        $user_id = Auth::user()->id;
        $content = $request->content;
        $post = DB::table('posts')
            ->insert(['content' => $content,'user_id' => $user_id,'status' => 0,'created_at' => date("Y-m-d H:i:s"),'updated_at' => date("Y-m-d H:i:s")]);
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
    }
}
