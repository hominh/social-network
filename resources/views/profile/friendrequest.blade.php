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
                <div class="col-sm-12 col-md-12">
                    @if ( session()->has('msg') )
                    <p class="alert alert-success">
                        {{ session()->get('msg') }}
                    </p>
                    @endif
                    @foreach($friendrequest as $item)
                        <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                            <div class="col-md-2 pull-left">
                                <img src="{{url('image')}}/{{$item->avatar}}" width="80px" height="80px" class="img-rounded"/>
                            </div>
                            <div class="col-md-7 pull-left">
                                <h3 style="margin:0px;"><a href="{{url('/profile')}}/{{$item->slug}}">{{ucwords($item->name)}}</a></h3>
                                <p><b>Gender:</b> {{$item->gender}}</p>
                                <p><b>Email:</b> {{$item->email}}</p>
                            </div>
                            <div class="col-md-3 pull-right">
                                <p>
                                    <a href="{{url('/accept')}}/{{$item->name}}/{{$item->id}}"  class="btn btn-info btn-sm">Confirm</a>
                                    <a href="{{url('/removerequest')}}/{{$item->id}}"  class="btn btn-default btn-sm">Remove</a>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
