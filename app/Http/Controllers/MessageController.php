<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages1 = DB::table('users')
                    ->join('conversations','users.id','=','conversations.user_one')
                    ->where('conversations.user_two','=',Auth::user()->id)->get();
        $messages2 = DB::table('users')
                    ->join('conversations','users.id','=','conversations.user_two')
                    ->where('conversations.user_one','=',Auth::user()->id)->get();
        $messages = array_merge($messages1->toArray(),$messages2->toArray());
        return $messages;
        //return view('message.index',compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getMessage($id) {
        /*$user_id = Auth::user()->id;
        $checkconversation = DB::table('conversations')
                            ->where('user_one','=',$user_id)
                            ->where('user_two','=',$id)
                            ->orWhere('user_one','=',$user_id)
                            ->get();
        if(count($checkconversation) != 0) {
            $usermessage = DB::table('messages')
                        ->where('messages.conversation_id',$checkconversation[0]->id)->get();
            return $usermessage;
        }
        else {
            echo "no message";
        }*/
        $messages = DB::table('messages')
                ->join('users','messages.user_from','users.id')
                ->where('messages.conversation_id','=',$id)
                ->get();
        return $messages;
    }

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
        $user_id = Auth::user()->id;
        $conversation_id = $request->conversation_id;
        $content = $request->content;
        $checkconversation = DB::table('messages')->where('conversation_id',$conversation_id)->get();
        if($checkconversation[0]->user_from == $user_id) {
            $userto = $checkconversation[0]->user_to;
        }
        $message = DB::table('messages')->insert([
            'user_to' => $userto,
            'user_from' => $user_id,
            'content' => $content,
            'status' => 1,
            'conversation_id' => $conversation_id
        ]);
        if($message) {
            $messages = DB::table('messages')
                    ->join('users','messages.user_from','users.id')
                    ->where('messages.conversation_id','=',$conversation_id)
                    ->get();

            return $messages;
        }
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
