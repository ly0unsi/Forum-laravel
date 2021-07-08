<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css"
        integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    @yield('title')
</head>

<body>

    <nav class="navbar  sticky-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand text-primary" style="font-weight:800;color:#323232" href="{{url('/')}}">
            Kra Wzid Kra
            <i style="font-size: 24px" class="fa fa-user-graduate"></i>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form action="{{url('search')}}" class="form-inline my-2 my-lg-0">
                @error('q')
                <div class="invalid-feedback">
                    {{$errors->first('q')}}
                </div>
                @enderror
                <input class="form-control form-control-sm mr-sm-2 @error('q') is-invalid @enderror" type="search"
                    value="{{$q ?? ''}}" name="q" placeholder="Search" aria-label="Search">

                <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="submit">Search</button>
            </form>
            <ul class="navbar-nav mr-1 ml-auto">
                <!-- Authentication Links -->
                <!-- Authentication Links -->
                @guest
                @if (Route::has('login'))
                <li class="nav-item">
                    <a class="btn btn-outline-dark btn-sm my-2 my-sm-0 p-1 mr-1"
                        href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="btn btn-outline-dark btn-sm mr-1 my-sm-0 p-1"
                        href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li style="border-radius: 15px"
                    class="nav-item show dropdown p-0 d-flex btn btn-sm btn-outline-dark notify pl-1">
                    <a href="{{url('profile/'.Auth::user()->id)}}"><img style="border: solid #f8f9fa 2px"
                            src="https://bootdey.com/img/Content/avatar/avatar6.png" class="rounded-circle move"
                            width="35" alt="User" /></a>
                    <a style="font-weight: 500;color:#2b2b2b;dispaly:none" id="navbarDropdown" class="hidden nav-link "
                        href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @unless (auth()->user()->unreadNotifications->isEmpty())
                <i class="fa text-dark fa-facebook"></i>
                <li style="border-radius: 15px"
                    class="nav-item show dropdown p-0 notify d-flex btn btn-sm btn-outline-dark mr-1 pl-1">

                    <a style="font-weight: 500;color:#2b2b2b;dispaly:none" id="navbarDropdown" class="hidden nav-link "
                        href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ auth()->user()->unreadNotifications->count() }} Notification(s)

                    </a>

                    <div class="dropdown-menu bg-dark text-white  dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @foreach (auth()->user()->unreadNotifications as $notification)
                        <a class="dropdown-item bg-dark text-white "
                            href="{{url('showFromNotification/'.$notification->data['topicid']."/".$notification->id)}}">

                            {{$notification->data['name']}} a posté un commentaire sur
                            <strong>
                                {{$notification->data['topictitle']}}
                            </strong>
                        </a>
                        @endforeach
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endunless
                @endguest


            </ul>

        </div>
    </nav>
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Inner sidebar -->
            <div class="inner-sidebar">
                <!-- Inner sidebar header -->
                <div class="inner-sidebar-header justify-content-center">
                    <button class="btn btn-primary has-icon btn-block" type="button" data-toggle="modal"
                        data-target="#threadModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-plus mr-2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Nouveau probleme
                    </button>
                </div>
                <!-- /Inner sidebar header -->

                <!-- Inner sidebar body -->
                <div class="inner-sidebar-body p-0 ">
                    <div class="p-3 h-100" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: -16px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" style="height: 100%">
                                        <div class="simplebar-content" style="padding: 16px;">
                                            <nav class="nav nav-pills nav-gap-y-1 flex-column">
                                                <a href="javascript:void(0)"
                                                    class="nav-link nav-link-faded has-icon active">All Threads</a>
                                                <a href="javascript:void(0)"
                                                    class="nav-link nav-link-faded has-icon">Popular this week</a>
                                                <a href="javascript:void(0)"
                                                    class="nav-link nav-link-faded has-icon">Popular all time</a>
                                                <a href="javascript:void(0)"
                                                    class="nav-link nav-link-faded has-icon">Solved</a>
                                                <a href="javascript:void(0)"
                                                    class="nav-link nav-link-faded has-icon">Unsolved</a>
                                                <a href="javascript:void(0)" class="nav-link nav-link-faded has-icon">No
                                                    replies yet</a>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 234px; height: 292px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                            <div class="simplebar-scrollbar"
                                style="height: 151px; display: block; transform: translate3d(0px, 0px, 0px);"></div>
                        </div>
                    </div>
                </div>
                <!-- /Inner sidebar body -->
            </div>
            <div class="modal fade" id="threadModal" tabindex="-1" role="dialog" aria-labelledby="threadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{url('topics')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header d-flex align-items-center bg-primary text-white">
                                <h6 class="modal-title mb-0" id="threadModalLabel">Nouveau sujet</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="threadTitle">Titre</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid
                                    @enderror" id="threadTitle" placeholder="Entrer le titre du topic" autofocus="" />
                                    <label for="threadTitle">Contenu</label>
                                    <textarea rows="8"
                                        class="form-control summernote  @error('body') is-invalid @enderror"
                                        name="body"></textarea>
                                </div>


                                <div class="custom-file form-control-sm" style="max-width: 300px;">
                                    <img id="output"
                                        style="max-width: 50%;margin-bottom:5px;border:1px solid crimson;border-radius:5px">

                                    <label style=" color: rgb(235, 235, 235);text-decoration:none"
                                        class=" btn btn-sm btn-danger">
                                        Set your topic image
                                        <input type="file" accept="image/*" name="image" id="file"
                                            onchange="loadFile(event)" style="display: none;">
                                    </label>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="loader-container">
                <div style="" class="loader">

                </div>
            </div>
            @yield('content')


            <script>
                $(window).on("load",function(){
                $(".loader-container").fadeOut(600);
            });
            </script>
            <script>
                var loadFile = function(event) {
                      var image = document.getElementById('output');
                      image.src = URL.createObjectURL(event.target.files[0]);
                  };
            </script>
            @yield('script')
</body>

</html>