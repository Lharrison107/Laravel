<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottleMail;
use App\Mail\CommentPostedMarkdown;

class NotifyUsersAboutComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CommentPosted  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        ThrottleMail::dispatch(
            new CommentPostedMarkdown($event->comment), 
            $event->comment->commentable->user
        );
        NotifyUsersPostWasCommented::dispatch($event->comment);
    }
}
