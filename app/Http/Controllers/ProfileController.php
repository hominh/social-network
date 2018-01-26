<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $data = Auth::user()->profile;
        return view('profile.index')->with('data', $data);
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
        echo $id;
    }

}
