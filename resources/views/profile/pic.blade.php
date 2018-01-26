@extends('profile.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{Auth::user()->name}}
                </div>

                <div class="panel-body">
                    <div class="col-md-4">
                        Welcome to profile
                        <img src="{{url('image')}}/{{Auth::user()->avatar}}" width="80px" height="80px" class="img-circle" />
                        <br /><br />
                        <form action="{{url('/')}}/uploadavatar" method="post" enctype="multipart/form-data">
                             {{ csrf_field() }}
                             <div class="form-group">
                                 <input type="file" name="avatar" class="custom-file-input" />
                             </div>
                             <div class="form-group">
                                 <input type="submit" class="btn btn-success" name="btn" />
                             </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
