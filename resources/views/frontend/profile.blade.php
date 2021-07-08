@extends('frontend.master')
@section('title')
<title>
    {{$user->name}}
</title>
@endsection
@section('content')


<div class="inner-main">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
        <div class="col-md-12">
            <div class="panel panel-default plain profile-panel col-md-12">

                <div class="panel-body ml-0 row col-md-12">
                    <div class="col-md-2" style="text-align: center">
                        <div class="profile-avatar relative">
                            <img class="img-responsive" width="120"
                                src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="profile picture">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="user-name">
                            {{$user->name}} <span style="font-size: 10px;position:absolute;padding-bottom:4px"
                                class="badge badge-pill badge-danger">@if ($user->name=='Abdllah')
                                Admin
                                @endif</span>
                        </div>
                        <div class="user-information">
                            <p>
                                {{$user->profile['bio']}}
                            </p>
                        </div>

                        <div class="profile-stats-info">
                            <a href="#" title="topics">
                                <strong>{{$user->topics->count()}} Sujet(s)</strong></a>
                        </div>
                        @can('editProfile', $user->profile)
                        <button type="button" data-toggle="modal" data-target="#threadModal2"
                            class="btn btn-primary btn-sm px-4 mt-3 py-0">
                            Editer le profile
                        </button>
                        @endcan



                    </div>

                </div>

                <div class="panel-footer white-content mt-2">
                    <ul class="profile-info">
                        <li><i class="fa fa-envelope"></i> {{$user->email}}</li>
                        <li><i class="fa fa-edit"></i> Web developer</li>
                        <li><i class="fa fa-share"></i> factory@mail.com</li>
                    </ul>
                </div>
            </div>
            <h5 class="text-dark">Les sujets</h5>
            @foreach ($topics as $topic)
            <div class="card mb-2">
                <div class="card-body p-2 p-sm-3">
                    <div class="media forum-item">
                        <a href="{{url('profile/'.$topic->user->id)}}"><img
                                src="https://bootdey.com/img/Content/avatar/avatar6.png" class="mr-3 rounded-circle"
                                width="50" alt="User" /></a>
                        <div class="media-body">
                            <h6><a href="{{url('topics/'.$topic->tid)}}" data-target=".forum-content"
                                    class="text-body">{{$topic->title}}</a></h6>
                            <p class="text-secondary">
                                <a href=" {{url('topics/'.$topic->tid)}}">
                                    {{$topic->body}}
                                </a>
                            </p>
                            <p class="text-muted"><span class="text-secondary font-weight-bold">
                                    {{$topic->created_at->diffForHumans()}}</span>
                                <span class="d-none ml-1 d-sm-inline-block"><i class="far fa-eye"></i>
                                    {{$topic->views}}</span>
                                <span><i class="far ml-1 fa-comment ml-2"></i>{{$topic->comments->count()}}</span>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="threadModal2" tabindex="-1" role="dialog" aria-labelledby="threadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{url('editProfile/'.$user->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header d-flex align-items-center bg-primary text-white">
                        <h6 class="modal-title mb-0" id="threadModalLabel">Editer le profile</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-1" style="text-align: center">
                                <div class="profile-avatar relative">
                                    <img id="output2" class="img-responsive rounded-circle" width="120">
                                </div>
                                <label style=" color: rgb(235, 235, 235);text-decoration:none"
                                    class=" btn btn-sm btn-danger p-0 px-1">
                                    Change
                                    <input type="file" accept="image/*" name="image" id="file" onchange="loadFil(even)"
                                        style="display: none;">
                                </label>
                            </div>
                            <label for="threadTitle">Username</label>
                            <input type="text" name="name" value="{{$user->name}}" class="form-control @error('name') is-invalid
                                    @enderror" id="threadTitle" placeholder="Entrer le titre du topic" autofocus="" />
                            <label for="threadTitle">Email</label>
                            <input type="email" value="{{$user->email}}"
                                class="form-control summernote  @error('email') is-invalid @enderror"
                                name="email"></input>
                            <label for="threadTitle">Bio</label>
                            <textarea rows="8" type="bio"
                                class="form-control summernote  @error('bio') is-invalid @enderror" name="bio">
                            {{$user->profile->bio ?? 'This is your bio'}}
                        </textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Editer</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    var loadFil = function(even) {
          var image2 = document.getElementById('output2');
          image2.src = URL.createObjectURL(even.target.files[0]);
      };
</script>
@endsection