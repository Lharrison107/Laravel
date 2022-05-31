<?php

namespace App\Providers;

// use App\Models\BlogPost;
use App\Policies\BlogPostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use LDAP\Result;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->is_admin && in_array($ability, ['update', 'delete'])) {
                return true;
            }
        });

        // Gate::resource('posts', BlogPostPolicy::class);
        // Gate::resource('users', UserPolicy::class);

        // Gate::define('update-post', function ($user, $post)
        // {
        //    return $user->id == $post->user_id;
        // });

        // Gate::define('delete-post', function ($user, $post)
        // {
        //    return $user->id == $post->user_id;
        // });

        // Gate::define('posts-update', 'App\Policies\BlogPostPolicy@update');

        // Gate::define('posts-delete', 'App\Policies\BlogPostPolicy@delete');

        // Gate::resource('posts', BlogPostPolicy::class);

        // Gate::before(function ($user, $ability)
        // {
        //    if ($user->is_admin && in_array($ability, ['update-post', 'delete-post'])) {
        //        return true;
        //    };
        // });

        // Gate::after(function ($user, $ability, $result)
        // {
        //    if ($user->is_admin) {
        //        return true;
        //    };
        // });

        
        Gate::define('home.secret', function ($user)
        {
          return $user->is_admin;
        });

    }
}
