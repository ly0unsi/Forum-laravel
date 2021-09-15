<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\profile;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ForumController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')->except('index', 'show', 'showProfile');
        $default = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtNWVnKZZfy-1CLo75eO5vLhTWFZyeyc7QaI6GgdSalXDIJOCA6t0DSdDDMabrTOdjdYs&usqp=CAU";
        View::share('default', $default);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thisMonth = Topic::whereMonth('created_at', '11')->orderBy('views', 'DESC')
            ->get();
        $allTime = Topic::orderBy('views', 'DESC')->get();
        $topics = Topic::latest()->paginate(10);
        return view('frontend.index', compact('topics', 'thisMonth', 'allTime'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|min:5',
                'body' => 'required|min:10'
            ]
        );
        if (request('image')) {
            $image = $request->image->getClientOriginalName();
            $request->image->storeAs('images', $image, 'public');
        }
        if (request('image')) {
            $data = [
                'title' => $request->title,
                'body' => $request->body,
                'image' => $image
            ];
        } else {
            $data = [
                'title' => $request->title,
                'body' => $request->body,

            ];
        }
        $topic = auth()->user()->topics()->create($data);
        Session::flash('success', 'Votre sujet est posté avec succés');
        return redirect('topics/' . $topic->tid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        $views = $topic->views += 1;
        $topic->save();
        return view('frontend.showTopic', compact('topic', 'views'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        $request->validate(
            [
                'title' => 'required|min:5',
                'body' => 'required|min:10',
            ]
        );
        if (request('image')) {
            $image = $request->image->getClientOriginalName();
            $request->image->storeAs('images', $image, 'public');
        }
        if (request('image')) {
            $data = [
                'title' => $request->title,
                'body' => $request->body,
                'image' => $image
            ];
        } else {
            $data = [
                'title' => $request->title,
                'body' => $request->body,

            ];
        }
        Session::flash('success', 'Votre sujet est modifié avec succés');
        $topic->update($data);
        return redirect('topics/' . $topic->tid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tid)
    {
        Topic::destroy($tid);
        return redirect('/');
    }
    public function showProfile(User $user)
    {
        $profile = $user->profile();
        $topics = $user->topics()->get();
        return view('frontend.profile', compact('user', 'profile', 'topics'));
    }
    public function editprofile(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => 'required|min:4',
                'email' => 'required|email',
            ]
        );
        $bio = $request->validate([]);

        if (request('profilePic')) {
            $profilePic = $request->profilePic->getClientOriginalName();
            $request->profilePic->storeAs('profilePics', $profilePic, 'public');
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,

        ];
        if (request('profilePic')) {
            $profileData = [
                'bio' => $request->bio,
                'profilePic' => $profilePic

            ];
        } else {
            $profileData = [
                'bio' => $request->bio,


            ];
        };
        $user->profile()->update($profileData);
        $user->update($userData);;
        Session::flash('success', 'Votre profile est modifié avec succés');
        return redirect('profile/' . $user->id);
    }
    public function search()
    {
        $q = request()->validate([
            'q' => 'required|min:3'
        ]);
        $q = $q['q'];
        $topics = Topic::where('title', 'LIKE', '%' . $q . '%')->orWhere('body', 'LIKE', '%' . $q . '%')->get();
        return view('frontend.search', compact('topics', 'q'));
    }
    public function showFrom(Topic $topic, DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return view('frontend.showTopic', compact('topic'));
    }
}
