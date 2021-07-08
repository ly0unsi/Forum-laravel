<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Topic;
use App\Notifications\newCommentposted;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store($tid)
    {
        request()->validate([
            'body' => 'required|min:5'
        ]);
        $comment = new Comment();
        $comment->content = request('body');
        $comment->user_id = auth()->user()->id;
        $topic = Topic::where('tid', $tid)->first();
        $topic->comments()->save($comment);
        //notification
        $topic->user->notify(new newCommentposted($topic, auth()->user()));
        return redirect('topics/' . $tid);
    }
    public function reply(Comment $comment)
    {
        request()->validate([
            'response' => 'required|min:5'
        ]);
        $reply = new Comment();
        $reply->content = request('response');
        $reply->user_id = auth()->user()->id;
        $comment->comments()->save($reply);
        return redirect()->back();
    }
}
