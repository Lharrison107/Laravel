<?php

namespace App\Http\ViewComposers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view) 
    {
        $mostCommented =  Cache::remember('blog-post-most-commented', now()->addSeconds(10), function() {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostBlogPosts = Cache::remember('user-most-active', now()->addSeconds(10), function() {
            return User::MostBlogPosts()->take(5)->get();
        });
        
        $mostBlogPostsLastMonth = Cache::remember('user-most-active-last-month', now()->addSeconds(10), function() {
            return User::WithMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('mostCommented', $mostCommented);
        $view->with('mostBlogPosts', $mostBlogPosts);
        $view->with('mostBlogPostsLastMonth', $mostBlogPostsLastMonth);

    }
}