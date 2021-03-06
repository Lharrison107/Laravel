<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\Console;
use Symfony\Component\Console\Logger\ConsoleLogger;

class PostController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $mostCommented =  Cache::remember('blog-post-most-commented', now()->addSeconds(10), function() {
        //     return BlogPost::mostCommented()->take(5)->get();
        // });

        // $mostBlogPosts = Cache::remember('user-most-active', now()->addSeconds(10), function() {
        //     return User::MostBlogPosts()->take(5)->get();
        // });
        
        // $mostBlogPostsLastMonth = Cache::remember('user-most-active-last-month', now()->addSeconds(10), function() {
        //     return User::WithMostBlogPostsLastMonth()->take(5)->get();
        // });

        return view(
            'posts.index', 
            [
                'posts' => BlogPost::latestWithRelations()->get(),
                // 'posts' => BlogPost::Latest()->withCount('comments')
                //     ->with('user')->with('tags')->get(),
            //     'mostCommented' => $mostCommented, 
            //     'mostBlogPosts' => $mostBlogPosts,
            //     'mostBlogPostsLastMonth' => $mostBlogPostsLastMonth,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $blogPost = BlogPost::create($validatedData);

        if ($request->hasFile('thumbnail')) {
            $imageName =  $blogPost->id . '.'.  $request->file('thumbnail')->guessExtension(); 
            $path = $request->file('thumbnail')->storeAs('thumbnails', $imageName);
            $blogPost->image()->save(
                Image::make(['path' => $path])
            );
        }

        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show', ['post' => $blogPost->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('posts.show', [
        //     'post' => BlogPost::with(['comments' => function($query) {
        //         return $query->latest();
        //     }])->findOrFail($id)
        // ]);
        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function() use($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                ->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $usersUpdate = [];
        $diffrence = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $diffrence--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);

        if (!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $diffrence);
        }
        
        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return view('posts.show', [
            'post' => BlogPost::with('comments')->findOrFail($id),
            'counter' => $counter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "!!!You cant update other's posts!!!");  
        // };
        $this->authorize($post);

       return view('posts.edit', ['post' => BlogPost::findOrFail($id)]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {   
        $post = BlogPost::findOrFail($id);
        
        // if (Gate::denies('update-post', $post)) {
        //   abort(403, "!!!You cant update other's posts!!!");  
        // }; 
        $this->authorize($post);

        $validated = $request->validated();
        $post->fill($validated);

        if ($request->hasFile('thumbnail')) {
            // dd($request);
            $imageName =  $post->id . '.'.  $request->file('thumbnail')->guessExtension(); 
            $path = $request->file('thumbnail')->storeAs('thumbnails', $imageName);
            
            if ($post->image) {
                Storage::delete($post->image->path);
                
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

       

        $post->save();

        // $request->session()->flash('status', 'Blog post was updated!!!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "!!!You cant delete other's posts!!!");  
        // };

        $this->authorize($post);

        $post->delete();
        
        // session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
