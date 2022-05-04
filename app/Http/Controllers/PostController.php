<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\DB;

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
        // DB::enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post) {
        //     foreach ($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        return view(
            'posts.index', 
            [
                'posts' => BlogPost::Latest()->withCount('comments')->get(),
                'mostCommented' => BlogPost::mostCommented()->take(5)->get(),
                'mostBlogPosts' => User::MostBlogPosts()->take(5)->get(),
                'mostBlogPostsLastMonth' => User::WithMostBlogPostsLastMonth()->take(5)->get(),
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
       $validated = $request->validated();
       $validated['user_id'] = $request->user()->id;
       $post = BlogPost::create($validated);

        // $post2 = BlogPost::make();
        // $post2->save();
        // this is how to get it to fill your model and submit it.

    //    $request->session()->flash('status', 'The blog post was created!');

       return redirect()->route('posts.show', ['post' => $post->id]);
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
        return view('posts.show', [
            'post' => BlogPost::with('comments')->findOrFail($id)
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

        $this->authorize('update-post', $post);

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

        $this->authorize('posts-update', $post);

        $validated = $request->validated();
        $post->fill($validated);
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

        $this->authorize('posts-delete', $post);

        $post->delete();
        
        // session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
