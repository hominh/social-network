<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .msg_main{
            background-color:#ffff;
            border-left:5px solid #F5F8FA;
            position: absolute;
            left: calc(25%);
        }
        .msg_right{
            background-color:#ffff;
            border-left:5px solid #F5F8FA;
            min-height:600px;
            position:fixed;
            right:0px
        }
        .msgDiv{
            position:fixed; left:0
        }
        .left-sidebar li { padding:10px;
            border-bottom:1px solid #ddd;
            list-style:none; margin-left:-20px}
        .msgDiv li:hover{
            cursor:pointer;
        }
        .jobDiv{border:1px solid #ddd; margin:10px; width:30%; float:left; padding:10px; color:#000}
        .caption li {list-style:none !important; padding:5px}
        .jobDiv .company_pic{width:50px; height:50px; margin:5px}
        .jobDetails h4{border:1px solid green; width:60%;
        padding:5px; margin:0 auto; text-align:center; color:green}
        .jobDetails .job_company{padding-bottom:10px; border-bottom:1px solid #ddd; margin-top:20px}
        .jobDetails .job_point{color:green; font-weight:bold}
        .jobDetails .email_link{padding:5px; border:1px solid green; color:green}
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
                            <li><a href="{{ url('/profile') }}/{{ Auth::user()->slug }}">Profile</a></li>
                            <li><a href="{{ url('/findfriends') }}">Find friends</a></li>
                            <li><a href="{{ url('/requests') }}">My request <span style="color:green; font-weight:bold;
                                       font-size:16px">({{App\Friendship::where('status', 0)
                                                  ->where('user_requested', Auth::user()->id)
                                                  ->count()}})</a></li>
                            <li><a href="{{ url('/friends') }}">Friends</a></li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="badge" style="background:red;">{{ $countnotifications }}</span>
                                </a>
                                <ul class="dropdown-menu" role="menu" style="width:320px">
                                    @foreach($notes as $note)
                                        <a href="{{url('/notifications')}}/{{$note->id}}">
                                        @if($note->status==1)
                                            <li style="background:#E4E9F2; padding:10px">
                                        @else
                                            <li style="padding:10px">
                                            @endif
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img src="{{url('image')}}/{{$item->avatar}}" style="width:50px; padding:5px; background:#fff; border:1px solid #eee" class="img-rounded">
                                                </div>

                                                <div class="col-md-10">
                                                    <b style="color:green; font-size:90%">{{ucwords($note->name)}}</b>
                                                    <span style="color:#000; font-size:90%">{{$note->note}}</span>
                                                    <br/>
                                                    <small style="color:#90949C"> <i aria-hidden="true" class="fa fa-users"></i>
                                            {{date('F j, Y', strtotime($note->created_at))}}
                                          at {{date('H: i', strtotime($note->created_at))}}</small>
                                                </div>

                                            </div>
                                            </li>
                                        </a>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{ url('/friends') }}"><i class="fa fa-users" aria-hidden="true"></i>Friends</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <img src="{{url('image')}}/{{ Auth::user()->avatar }}" width="30px" height="30px" class="img-rounded"/> <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('editprofile') }}">Edit profile</a></li>
                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/profile.js') }}"></script>
</body>
</html>
