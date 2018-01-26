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
                      <div class="panel-heading">{{Auth::user()->name}}</div>
                      <div class="panel-body">
                          <div class="col-sm-12 col-md-12">
                              @foreach($alluser as $item)
                                <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                                    <div class="col-md-2 pull-left">
                                        <img src="{{url('image')}}/{{$item->avatar}}" width="80px" height="80px" class="img-rounded"/>
                                    </div>
                                    <div class="col-md-7 pull-left">
                                        <h3 style="margin:0px;">
                                            <a href="{{url('/profile')}}/{{$item->slug}}">{{$item->name}}</a>
                                        </h3>
                                        <p><i class="fa fa-globe"></i> {{$item->city}} - {{$item->country}}</p>
                                        <p>{{$item->about}}</p>
                                    </div>
                                    <div class="col-md-3 pull-right">
                                        @if($item->check =='reed')
                                            <p>Request already sent</p>
                                        @else
                                            <p>
                                                <a href="{{url('/')}}/addfriend/{{$item->id}}" class="btn btn-info btn-sm">Add to friend</a>
                                            </p>
                                        @endif
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
