@extends('frontend.master')
@section('title')
<title>
    {{$topic->title}}
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
        <div class="card mb-2">
            <div class="card-body p-2 p-sm-3">
                <div class="media forum-item">
                    <a href="{{url('profile/'.$topic->user->id)}}"><img
                            src="https://bootdey.com/img/Content/avatar/avatar1.png" class="mr-3 rounded-circle"
                            width="50" alt="User" /></a>
                    <div class="media-body">
                        <div style="margin-left:0px;align-items:center;align-items:baseline;" class="row">
                            <h6><a href="#" data-toggle="collapse" data-target=".forum-content"
                                    class="text-body">{{$topic->title}}</a></h6>
                            @can('update', $topic)
                            <button class="btn btn-warning btn-sm ml-2 p-0 px-1 my-sm-0" type="button"
                                data-toggle="modal" data-target="#threadModal2">Editer</button>
                            @endcan

                            @can('delete', $topic)
                            <button style="margin-bottom: 10px" class="btn btn-danger btn-sm ml-2 p-0 px-1 my-sm-0"
                                type="button" data-toggle="modal" data-target="#exampleModal">Supprimer</button>
                            @endcan


                        </div>
                        <p class="text-secondary">
                            {{$topic->body}}
                        </p>
                        @if ($topic->image)
                        <p>
                            <a href="#">
                                <img id="imgtab" class='small' src="{{url('/storage/images/'.$topic->image)}}">
                            </a>
                        </p>
                        @endif

                        <p class="text-muted">Posté par <a href="{{url('profile/'.$topic->user->id)}}"
                                class="text-danger">{{$topic->user['name']}}</a>
                            <span
                                class="text-secondary ml-1 font-weight-bold">{{$topic->created_at->diffForHumans()}}</span>
                            <span class="d-none ml-1 d-sm-inline-block"><i class="far fa-eye"></i>
                                {{$topic->views}}</span>
                            <span><i class="far fa-comment ml-2"></i>{{$topic->comments->count()}}</span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <h5 class="ml-4">Les commentaires</h5>
        @foreach ($topic->comments as $comment)
        <div class="card mb-2 ml-4">
            <div class="card-body p-2 p-sm-3">
                <div class="media forum-item">
                    <a href="{{url('profile/'.$comment->user->id)}}"><img
                            src="https://bootdey.com/img/Content/avatar/avatar4.png" class="mr-3 rounded-circle"
                            width="50" alt="User" /></a>
                    <div class="media-body">
                        <div style="margin-left:0px;align-items:center;align-items:baseline;" class="row">
                            <h6><a href="#" data-toggle="collapse" data-target=".forum-content"
                                    class="text-body">{{$comment->user->name}}</a></h6>
                        </div>
                        <p class="text-secondary">
                            {{$comment->content}}
                        </p>
                        <p class="text-muted">Posté
                            <span
                                class="text-secondary ml-1 font-weight-bold">{{$comment->created_at->diffForHumans()}}</span>
                            </span>
                            <br>
                            @auth
                            <button id="espond-btn" onclick="toggleReplyComment({{$comment->cid}})"
                                class="btn p-0 font-weight-light px-1 mt-1 btn-primary btn-sm">
                                Repondre
                            </button>
                            <form id="replyComment-{{$comment->cid}}" class="d-none"
                                action="{{url('reply/'.$comment->cid)}}" class="mt-1" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="Votre commentaire">Votre commentaire</label>
                                    <textarea class="form-control @error('response') is-invalid @enderror"
                                        name="response" id="body" rows="2"></textarea>
                                    @error('response')
                                    <div class="invalid-feedback">
                                        {{$errors->first('reponse')}}
                                    </div>
                                    @enderror

                                </div>
                                <button type="submit" id="respond-btn"
                                    class="btn p-0 font-weight-light px-1 btn-primary btn-sm">
                                    Envoyer
                                </button>
                                <i style="color:blue;" class="fa fa-facebook"></i>

                            </form>
                            @endauth
                            @foreach ($comment->comments as $reply)
                            <div class="card mb-2 ml-4">
                                <div class="card-body p-2 p-sm-3">
                                    <div class="media forum-item">
                                        <a href="{{url('profile/'.$reply->user->id)}}"><img
                                                src="https://bootdey.com/img/Content/avatar/avatar4.png"
                                                class="mr-3 rounded-circle" width="50" alt="User" /></a>
                                        <div class="media-body">
                                            <div style="margin-left:0px;align-items:center;align-items:baseline;"
                                                class="row">
                                                <h6><a href="#" data-toggle="collapse" data-target=".forum-content"
                                                        class="text-body">{{$reply->user->name}}</a></h6>
                                            </div>
                                            <p class="text-secondary">
                                                {{$reply->content}}
                                            </p>
                                            <p class="text-muted">Posté
                                                <span
                                                    class="text-secondary ml-1 font-weight-bold">{{$reply->created_at->diffForHumans()}}</span>
                                                </span>
                                                <br>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </p>
                    </div>

                </div>
            </div>
        </div>
        @endforeach


        <form class="ml-4" action="{{url('comments/'.$topic->tid)}}" class="mt-1" method="post">
            @csrf
            <div class="form-group">
                <label for="Votre commentaire">Votre commentaire</label>
                <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body"
                    rows="5"></textarea>
                @error('body')
                <div class="invalid-feedback">
                    {{$errors->first('body')}}
                </div>
                @enderror
                <button type="submit" class="btn btn-sm mt-1 btn-danger">Soummettre mon commentaire</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="threadModal2" tabindex="-1" role="dialog" aria-labelledby="threadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('topics/'.$topic->tid)}}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header d-flex align-items-center bg-primary text-white">
                    <h6 class="modal-title mb-0" id="threadModalLabel">Editer le sujet</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="threadTitle">Titre</label>
                        <input type="text" value="{{$topic->title}}" name="title" class="form-control" @error('title')
                            is-invalid @enderror id="threadTitle" placeholder="Entrer le titre du topic" autofocus="" />
                        <label for="threadTitle">Contenu</label>
                        <textarea class="form-control summernote" @error('body') is-invalid @enderror name="body"
                            rows="8">{{$topic->body}}</textarea>
                    </div>


                    <div class="custom-file form-control-sm" style="max-width: 300px;">
                        <img id="output" src="{{url('storage/images/'.$topic->image)}}"
                            style="max-width: 50%;margin-bottom:5px;border:1px solid crimson;border-radius:5px">

                        <label style=" color: rgb(235, 235, 235);text-decoration:none" class=" btn btn-sm btn-danger">
                            Set your topic image
                            <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)"
                                style="display: none;">
                        </label>

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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Suprimmer le sujet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Tu es sur Monsieur ?!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Annuler</button>
                <form method="POST" action="{{url('topics/'.$topic->tid)}}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var $window = $(window),
    currentWindowSize,
    flagIs,
    flagWas = '';

function res() {
    currentWindowSize = $window.width();

//set flag string to LOW if...    
if (currentWindowSize <= 999) {
    flagIs = "low";
}
//set flag string to HIGH if...
else if (currentWindowSize >= 1000 ) {
    flagIs = "high";
}

if (flagIs != flagWas)
{
        // if new string is low - so change css to low setting
       if (flagIs == 'high') {
        var small={width: "140px",height: "140px"};
        var large={width: "700px",height: "700px"};
        var count=1; 
        $("#imgtab").css(small).on('click',function () { 
            $(this).animate((count==1)?large:small);
            count = 1-count;
        });
       }  else if (flagIs == 'low') {
        var small={width: "140px",height: "140px"};
        var large={width: "258px",height: "258px"};
        var count=1; 
        $("#imgtab").css(small).on('click',function () { 
            $(this).animate((count==1)?large:small);
            count = 1-count;
        });
       }
       flagWas = flagIs;
}
}
res();

// the same function will be execute each time we resize window
$(window).resize(function () {
   res(); 
});
    });


    var loadFile = function(event) {
          var image = document.getElementById('output');
          image.src = URL.createObjectURL(event.target.files[0]);
      };


      function toggleReplyComment(id){
          let element=document.getElementById('replyComment-'+id);
          element.classList.toggle('d-none');
      }
</script>

@endsection