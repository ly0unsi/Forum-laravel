@extends('frontend.master')
@section('title')
<title>
    Searching for "{{$q}}"
</title>
@endsection
@section('content')
<!-- Inner main -->
<div class="inner-main">
    <!-- Inner main header -->

    <!-- /Inner main header -->

    <!-- Inner main body -->

    <!-- Forum List -->
    <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
        <h6>
            {{$topics->count()}} result(s) for "{{$q}}"
        </h6>
        @foreach ($topics as $topic)
        <div class="card mb-2">
            <div class="card-body p-2 p-sm-3">
                <div class="media forum-item">
                    <a href="{{url('profile/'.$topic->user->id)}}"><img
                            src="{{url('/storage/profilePics/'.$topic->user->profile['profilePic'])}}"
                            class="mr-3 rounded-circle" width="50" alt="User" /></a>
                    <div class="media-body">
                        <h6><a href="{{url('topics/'.$topic->tid)}}" data-target=".forum-content"
                                class="text-body">{{$topic->title}}</a></h6>
                        <p class="text-secondary">
                            <a href=" {{url('topics/'.$topic->tid)}}">
                                {{$topic->body}}
                            </a>
                        </p>
                        <p class="text-muted">Posté par <a href="{{url('profile/'.$topic->user->id)}}"
                                class="text-danger">{{$topic->user['name']}}</a><span
                                class="text-secondary font-weight-bold"> {{$topic->created_at->diffForHumans()}}</span>
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
    <!-- /Forum List -->

    <!-- Forum Detail -->

    <!-- /Forum Detail -->

    <!-- /Inner main body -->
</div>
<!-- /Inner main -->
</div>

<!-- New Thread Modal -->

</div>
@endsection
