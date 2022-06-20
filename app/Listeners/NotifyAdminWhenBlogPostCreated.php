<?php

namespace App\Listeners;

use App\Events\BlogPostPosted;
use App\Jobs\ThrottleMail;
use App\Mail\BlogPostAdded;
use App\Models\User;

class NotifyAdminWhenBlogPostCreated
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BlogPostPosted $event)
    {
        User::ThatIsAdmin()->get()
            ->map(function (User $user) {
                ThrottleMail::dispatch(
                    new BlogPostAdded(),
                    $user
                );
            });
    }
}
