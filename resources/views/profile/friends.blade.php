@extends('profile.master')
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{Auth::user()->slug}}">Profile</a></li>
        </ol>
        <div class="row">
            @include('profile.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">{{Auth::user()->name}}, Your Friends</div>
                    <div class="panel-body">
                        <div class="col-sm-12 col-md-12">
                            @if ( session()->has('msg') )
                                <p class="alert alert-success">
                                    {{ session()->get('msg') }}
                                </p>
                            @endif
                            @foreach($friends as $item)
                                <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                                    <div class="col-md-2 pull-left">
                                        <img src="{{url('image')}}/{{$item->avatar}}" width="80px" height="80px" class="img-rounded"/>
                                    </div>
                                    <div class="col-md-7 pull-left">
                                        <h3 style="margin:0px;"><a href="">{{ucwords($item->name)}}</a></h3>
                                        <p><b>Gender:</b> {{$item->gender}}</p>
                                        <p><b>Email:</b> {{$item->email}}</p>
                                    </div>
                                    <div class="col-md-3 pull-right">
                                        <p><a href="{{url('/unfriend')}}/{{$item->id}}"  class="btn btn-default btn-sm">Unfriend</a></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
