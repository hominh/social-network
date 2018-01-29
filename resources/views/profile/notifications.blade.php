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
                            @if ( session()->has('msg') )
                                <p class="alert alert-success">
                                    {{ session()->get('msg') }}
                                </p>
                            @endif
                            @foreach($notes as $item)
                                <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                                    <ul>
                                        <li>
                                            <p><a href="{{url('/profile')}}/{{$item->slug}}" style="font-weight: bold; color:green">
                                            {{$item->name}}</a> {{$item->note}}</p>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
