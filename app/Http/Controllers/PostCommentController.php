<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request) 
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        // Mail::to($post->user)->send(
        //     // new CommentPosted($comment)
        //     new CommentPostedMarkdown($comment)
        // );
        
        Mail::to($post->user)->queue(
            new CommentPostedMarkdown($comment)
        );

        NotifyUsersPostWasCommented::dispatch($comment);

        // $when = now()->addMinutes(1); 

        // Mail::to($post->user)->later(
        //     $when,
        //     new CommentPostedMarkdown($comment)
        // );

        return redirect()->back()
            ->withStatus('Comment was created!');
    }
}
