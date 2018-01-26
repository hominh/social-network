@extends('profile.master')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{Auth::user()->slug}}">Profile</a></li>
    </ol>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Auth::user()->name}}
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <img src="{{url('image')}}/{{Auth::user()->avatar}}" width="80px" height="80px" class="img-circle" />
                                <a href="{{url('/')}}/changeavatar">Change avatar</a>
                                <div class="caption">
                                    <h3>{{ucwords(Auth::user()->name)}}</h3>
                                    <p>
                                        {{$data->country}} - {{$data->city}}
                                    </p>
                                    <a href="{{url('/editprofile')}}" class="btn btn-primary" role="button">Edit profile</a>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <h4>About</h4>
                            <p>{{$data->about}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
