<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Profile;
use App\Friendship;
use App\Notification;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $datas = DB::table('users')
             ->leftJoin('profiles', 'profiles.user_id','users.id')
             ->where('slug', $slug)
             ->get();
        //dd($data);
        //return view('profile.index', compact('data'));
        return view('profile.index',compact('datas'))->with('data', Auth::user()->profile);
    }

    public function uploadAvatar(Request $request) {
        if($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = $file->getClientOriginalName();
            $path = 'image';
            $file->move($path,$filename);

            //Update data
            $user_id = Auth::user()->id;
            DB::table('users')->where('id','=',$user_id)->update(['avatar'=>$filename]);
            return view('profile.index');

        }
        else {
            echo "Please select image file to upload";
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
    public function edit()
    {
        $data = Auth::user()->profile;
        return view('profile.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id = Auth::user()->id;
        DB::table('profiles')->where('user_id', $user_id)->update($request->except('_token'));
        return back();
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

    public function findFriends()
    {
        $user_id = Auth::user()->id;
        $result = array();
        $alluser = DB::table('profiles')
                    ->leftJoin('users','profiles.user_id','=','users.id')
                    ->where('users.id', '!=', $user_id)->get();
        foreach($alluser as $item) {
            $checkrequested = DB::table('friendships')
                            ->where('user_requested','=',$item->id)
                            ->where('requester','=',$user_id)
                            ->first();
            if(empty($checkrequested)) {
                array_push($result,"notrq");
            }
            else {
                array_push($result,"reed");
            }
        }
        for($i = 0; $i < count($alluser); $i++) {
            $alluser[$i]->check = $result[$i];
        }
        return view('profile.findfriend',compact('alluser'));
    }

    public function sendRequest($id)
    {
        return Auth::user()->addFriend($id);
        //echo $id;
    }

    public function requests() {
        //requester: current user login
        $user_id = Auth::user()->id;
        $friendrequest = DB::table('friendships')
                        ->rightJoin('users','users.id','=','friendships.requester')
                        ->where('friendships.status','=','0')
                        ->where('friendships.user_requested', '=', $user_id)->get();
        //dd($friendrequest);
        return view('profile.friendrequest',compact('friendrequest'));
    }

    public function accept($name,$id) {
        $user_id = Auth::user()->id;
        $checkrequest = Friendship::where('requester',$id)
                        ->where('user_requested',$user_id)
                        ->first();
        if($checkrequest) {
            //update
            $update = DB::table('friendships')
                    ->where('user_requested',$user_id)
                    ->where('requester',$id)
                    ->update(['status'=>1]);
            $notifications = new Notification;
            $notifications->note = 'Accept your friend request';
            $notifications->user_hero = $id;
            $notifications->user_logged = $user_id; //me
            $notifications->status = 1;
            $notifications->save();
            if($notifications) {
                return back()->with('msg','You are now friend with this ' . $name);
            }
            else {
                echo "can not update";
            }
        }
        else {
            return view('profile.friendrequest')->with('msg','You are now friend with this user');
        }
    }

    public function removeRequest($id) {
        $user_id = Auth::user()->id;
        DB::table('friendships')
            ->where('user_requested','=',$user_id)
            ->where('requester','=',$id)
            ->delete();
        return back()->with('msg', 'Request has been deleted');
    }

    public function friends() {
        $user_id = Auth::user()->id;
        $friends1 = DB::table('friendships')
                ->leftJoin('users', 'users.id', 'friendships.user_requested')
                ->where('status', 1)
                ->where('requester', $user_id) // who is loggedin
                ->get();
        //dd($friends1);
        $friends2 = DB::table('friendships')
                ->leftJoin('users', 'users.id', 'friendships.requester')
                ->where('status', 1)
                ->where('user_requested', $user_id) // who is loggedin
                ->get();
        //dd($friends2);
        $friends = array_merge($friends1->toArray(),$friends2->toArray());
        return view('profile.friends', compact('friends'));
    }

    public function notifications($id) {
        $user_id = Auth::user()->id;
        $notes = DB::table('notifications')
                ->leftJoin('users','users.id','=','notifications.user_logged')
                ->where('notifications.id','=',$id)
                ->where('notifications.user_hero','=',$user_id)
                ->orderBy('notifications.created_at', 'desc')
                ->get();
        //dd($notes);
        return view('profile.notifications',compact('notes'));
    }

}
