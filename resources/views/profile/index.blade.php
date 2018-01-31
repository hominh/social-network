@extends('profile.master')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{Auth::user()->slug}}">Profile</a></li>
    </ol>
    <div class="row">
        @include('profile.sidebar')
        @foreach($datas as $item)
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{$item->name}}
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <h3 align="center">{{$item->name}}</h3>
                                <img src="{{url('image')}}/{{$item->avatar}}" width="120px" height="120px" class="img-circle" />
                                <!--<a href="{{url('/')}}/changeavatar">Change avatar</a>!-->
                                <div class="caption">
                                    <h3 align="center">{{ucwords($item->name)}}</h3>
                                    <p align="center">
                                            {{$item->country}} - {{$item->city}}
                                    </p>
                                    @if($item->user_id == Auth::user()->id)
                                    <p align="center"><a href="{{url('/editprofile')}}" class="btn btn-primary" role="button">Edit profile</a></p>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <h4 class=""><span class="label label-default">About</span></h4>
                            <p>{{$item->about}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
