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
        $user_id = Auth::user()->id;
        $messages1 = DB::table('users')
                    ->join('conversations','users.id','=','conversations.user_one')
                    ->where('conversations.user_two','=',Auth::user()->id)->get();
        $messages2 = DB::table('users')
                    ->join('conversations','users.id','=','conversations.user_two')
                    ->where('conversations.user_one','=',Auth::user()->id)->get();
        $messages = array_merge($messages1->toArray(),$messages2->toArray());
        //$messages = DB::table('users')->where('users.id','!=',$user_id)->get();
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
    public function newMessage() {
        $user_id = Auth::user()->id;
        $friends1 = DB::table('friendships')
                    ->leftJoin('users','users.id','=','friendships.user_requested')
                    ->where('friendships.status','=',1)
                    ->where('friendships.requester','=',$user_id)
                    ->get();
        $friends2 = DB::table('friendships')
                    ->leftJoin('users','users.id','=','friendships.requester')
                    ->where('friendships.status','=',1)
                    ->where('friendships.user_requested','=',$user_id)
                    ->get();
        $friends = array_merge($friends1->toArray(),$friends2->toArray());
        return view('message.newmessage',compact('friends'));
    }
    public function sendNewMessage(Request $request) {
        $content = $request->content;
        $friend_id = $request->friend_id;
        $user_id = Auth::user()->id;
        $checkconversation1 = DB::table('conversations')->where('user_one','=',$user_id)
                                ->where('user_two','=',$friend_id)
                                ->get();
        $checkconversation2 = DB::table('conversations')->where('user_two','=',$user_id)
                                ->where('user_one','=',$friend_id)
                                ->get();
        $checkconversation = array_merge($checkconversation1->toArray(),$checkconversation2->toArray());
        if(count($checkconversation) != 0 ) {
            //Old Message
            $old_conversationid = $checkconversation[0]->id;
            $msgsent = DB::table('messages')->insert([
                'user_from' => $user_id,
                'user_to' => $friend_id,
                'content' => $content,
                'conversation_id' => $old_conversationid,
                'status' => 1
            ]);
        }
        else {
            //new message
            $new_conversationid = DB::table('conversations')->insertGetId([
                'user_one' => $user_id,
                'user_two' => $friend_id
            ]);
            echo $new_conversationid;
            $msgsent = DB::table('messages')->insert([
                'user_from' => $user_id,
                'user_two' => $friend_id,
                'content' => $content,
                'conversation_id' => $new_conversationid,
                'status' => 1
            ]);
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
