@extends('frontend.master')
@section('title')
<title>
    L'acceuill
</title>
@endsection
@section('content')
<!-- Inner main -->
<div class="inner-main">
    <!-- Inner main header -->
    <div class="inner-main-header">
        <button type="button" class="btn btn-outline-dark btn-sm nav-icon  nav-link-faded mr-3 d-md-none"
            data-toggle="inner-sidebar">Slide</button>
        <select class="custom-select custom-select-sm w-auto mr-1">
            <option selected="">Latest</option>
            <option value="1">Popular</option>
            <option value="3">Solved</option>
            <option value="3">Unsolved</option>
            <option value="3">No Replies Yet</option>
        </select>

    </div>
    <!-- /Inner main header -->

    <!-- Inner main body -->

    <!-- Forum List -->
    <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
        @foreach ($topics as $topic)
        <div class="card mb-2">
            <div class="card-body p-2 p-sm-3">
                <div class="media forum-item">
                    <a href="{{url('profile/'.$topic->user->id)}}">
                        @if($topic->user->profile['profilePic']!==$default)
                        <img src="{{url('/storage/profilePics/'.$topic->user->profile['profilePic'])}}"
                            class="mr-3 rounded-circle" width="50" alt="User" />
                        @else
                        <img style="border: solid #f8f9fa 2px" src="{{$default}}" class="rounded-circle move" width="50"
                            alt="User" />
                        @endif
                    </a>
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





        <div class="row ml-1 col-md-12" style="text-align: center;justify-content:center">
            {{ $topics->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
        </div>
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
