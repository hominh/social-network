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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
