<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Social network</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <script src="https://use.fontawesome.com/595a5020bd.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    </head>
    <body>
        @if (Route::has('login'))
        <div class="top-right links" style="position:fixed">
            @if (Auth::check())
            <a href="{{url('jobs')}}" style="background-color:#283E4A;color:#fff; padding:5px 15px 5px 15px; border-radius:5px">Find Job</a>
            <a href="{{ url('/home') }}">Dashboard (<span style="text-transform:capitalize;color:green">{{ucwords(Auth::user()->name)}}</span>)</a>
            <a href="{{ url('/logout') }}">Logout</a>
            @else
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
            @endif
        </div>
        @endif
        <div class="flex-center position-ref full-height">
            <div class="col-md-12"  id="app">
            @if(Auth::check())
                <div class="col-md-3 left-sidebar hidden-xs hidden-sm" style="position:fixed; left:10px">
                    <ul>
                        <li>
                            <a href="{{ url('/profile') }}/{{Auth::user()->slug}}"> <img src="{{Config::get('app.url')}}/public/img/{{Auth::user()->pic}}" width="32" style="margin:5px"  />{{Auth::user()->name}}</a>
                        </li>
                        <li>
                            <a href="{{url('/')}}"> <img src="{{Config::get('app.url')}}:8000/image/news_feed.png" width="32" style="margin:5px"  />News Feed</a>
                        </li>
                        <li>
                            <a href="{{url('/friends')}}"> <img src="{{Config::get('app.url')}}:8000/image/friends.png" width="32" style="margin:5px"  />Friends </a>
                        </li>
                        <li>
                            <a href="{{url('/messages')}}"> <img src="{{Config::get('app.url')}}:8000/image/msg.png" width="32" style="margin:5px"  />Messages</a>
                        </li>
                        <li>
                            <a href="{{url('/findFriends')}}"> <img src="{{Config::get('app.url')}}:8000/image/friends.png" width="32" style="margin:5px"  />Find Friends</a>
                        </li>
                        <li>
                            <a href="{{url('/jobs')}}"> <img src="{{Config::get('app.url')}}:8000/image/jobs.png" width="32" style="margin:5px"  />Find Jobs</a>
                        </li>
                    </ul>
                </div>
                <!-- left side end -->
                <!-- center content start -->
                <div class="col-md-6 col-sm-12 col-xs-12 center-con">
                    <div class="posts_div">
                        <div class="head_har">
                            <i class="fa fa-edit"></i> @{{msg}}
                        </div>
                        <div style="background-color:#fff; padding:10px">
                            <div class="row">
                                <div class="col-md-1 col-md-2 pull-left">
                                    <img src="{{Config::get('app.url')}}:8000/image/{{Auth::user()->avatar}}" style="width:50px; margin:5px;  border-radius:100%">
                                </div>
                                <div class="col-md-11 col-sm-10 pull-right">
                                    <div v-if="!image">
                                        <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                                            {{ csrf_field() }}
                                            <textarea v-model="content" id="postText" class="form-control" placeholder="what's on your mind ?"></textarea>
                                            <button type="submit" class="btn btn-sm btn-primary pull-right" style="margin:10px; padding:5 15 5 15; background-color:#4267b2" id="postBtn">Post</button>
                                        </form>
                                    </div>
                                    <div v-if="!image" style="position:relative;display:inline-block">
                                        <div style="border:1px solid #ddd; border-radius:10px; background-color:#efefef; padding:3 15 3 10; margin-bottom:10px">
                                            <i class="fa fa-file-image-o"></i> <b>photo</b>
                                            <input type="file"  style="position:absolute;left:0;top:0; opacity:0"/>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="upload_wrap">
                                            <textarea v-model="content" id="postText" class="form-control" placeholder="what's on your mind ?"></textarea>
                                            <b @click="removeImg" style="right:0;position:absolute;cursor:pointer">Cancel</b>
                                            <img :src="image" style="width:100px; margin:10px;"/><br>
                                        </div>
                                        <button @click="uploadImg" class="btn btn-sm btn-info pull-right" style="margin:10px">Post</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
                <div v-for="post,key in posts" >
                    <div class="col-md-12 all_posts">
                        <div class="col-md-1 pull-left">
                            <img :src="'{{url('image')}}/' + post.user.avatar" style="width:50px; border-radius:100%">
                        </div>
                    <div class="col-md-10" style="margin-left:10px;">
                        <div class="row">
                            <div class="col-md-11">
                                <p>
                                    <a :href="'{{url('profile')}}/' +  post.user.slug" class="user_name"> @{{post.user.name}}</a> <br>
                                    <span style="color:#AAADB3">  @{{ post.created_at | myOwnTime}}
                                        <i class="fa fa-globe"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-1 pull-right">
                                <!-- delete button goes here -->
                                <a href="#" data-toggle="dropdown" style="font-size:40px; color:#ccc; left:-10px" aria-haspopup="true">...</a>
                                <div class="dropdown-menu">
                                    <li><a data-toggle="modal" :data-target="'#myModal' + post.id" @click="openModal(post.id)">Edit</a></li>
                                    <li><a>some more action</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li v-if="post.user_id == '{{Auth::user()->id}}'">
                                        <a @click="deletePost(post.id)">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    </li>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" :id="'myModal'+ post.id" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit Post</h4>
                                            </div>
                                            <div class="modal-body">
                                                <textarea v-model="updatedContent" class="form-control">@{{post.content}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success" data-dismiss="modal" @click="updatePost(post.id)">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                            </div>
                        </div>
                    </div>
                    <p class="col-md-12" style="color:#000; margin-top:15px; font-family:inherit">
                        @{{post.content}}
                        <br>
                        <img v-if="post.image" :src="'<?php echo Config::get('app.url');?>/public/img/' + post.image" width="200"/>
                    </p>
                    <div style="padding:10px; border-top:1px solid #ddd" class="col-md-12">
                        <div class="col-md-4">

                            <p>
                                <i class="fa fa-thumbs-up likeBtn" @click="likePost(post.id)">Like</i>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p @click="commentSeen= !commentSeen" class="commentHand">
                              Comments <b></b>
                            </p>
                        </div>
                      </div>
                    </div>
                    <div id="commentBox" v-if="commentSeen">
                        <div class="commet_form">
                            <!-- send comment-->
                            <textarea class="form-control" v-model="commentData[key]"></textarea>
                            <button class="btn btn-success" @click="addComment(post,key)">Send</button>
                        </div>
                        <ul v-for="comment in post.comments">
                            <li v-if="comment.user_id=={{Auth::user()->id}}">
                                <a href="{{url('profile')}}">You</a>

                            </li>
                            <li v-else>
                                <a :href="'{{url('/profile')}}/' + post.user.slug">
                                    @{{post.user.name}}
                                </a>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <!-- center content end -->

    <!-- right side start -->
        <div class="col-md-3 right-sidebar hidden-sm hidden-xs" style="position:fixed; right:10px">
            <h3 align="center">Right Sidebar</h3>
        </div>
    <!-- right side end -->
        @else
        <h1 align="center">Please login</h1>
        @endif
        </div>
    </div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
$(document).ready(function(){
$('#postBtn').hide();
    $("#postText").hover(function() {
        $('#postBtn').show();
    });
});
</script>
</body>
</html>
