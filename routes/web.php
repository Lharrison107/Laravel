<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$posts = [
    
];
Route::get('/', [HomeController::class, 'home'])
    ->name('home.index');

Route::get('/secret', [HomeController::class, 'secret'])
    ->name('home.secret')
    ->middleware('can:home.secret');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');

Route::get('/single', AboutController::class)
    ->name('single');

Route::resource('posts', PostController::class);

Route::get('/posts/tag/{tag}', PostTagController::class . '@index')->name('posts.tags.index');

Route::resource('posts.comments', PostCommentController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Auth::routes();
    // ->middleware('auth');
    // ->only(['index', 'show', 'create', 'store', 'edit', 'update']);

// Route::get('/posts', function () use($posts) {
//     // dd(request()->all()); 
//     // dd((int)request()->input('page', 1));
//     // dd((int)request()->query('page', 1));
//     return view('posts.index', ['posts' => $posts]);
// })->name('posts.recent.index');

// Route::get('/posts/{id}', function ($id) use($posts) {
//     abort_if(!isset($posts[$id]), 404);

//     return view('posts.show', ['post' => $posts[$id]]);
// })->name('posts.show');

Route::get('/recent-posts/{days_ago?}', function ($daysAgo = 20) {
    return 'Posts from ' . $daysAgo . ' days ago';
})->name('posts.recent.index')->middleware('auth');

Route::prefix('/fun')->name('fun.')->group(function() use($posts){
    Route::get('/responses', function () use($posts) {
        return response($posts, 201)
            ->header('Content-Type', 'application/json')
            ->cookie('MY_COOKIE', 'Lyric Harrison', 3600);
    })->name('posts.recent.index');
    
    Route::get('/redirect', function () {
        return redirect('/contact');
    })->name('redirect.contact');
    
    Route::get('/back', function () {
        return back();
    })->name('back');
    
    Route::get('/named-route', function () {
        return redirect()->route('posts.show', ['id' => 1]);
    })->name('named.route');
    
    Route::get('/away', function () {
        return redirect()->away('https://google.com');
    })->name('away');
    
    Route::get('/json', function () use($posts){
        return response()->json($posts);
    })->name('json');
    
    Route::get('/download', function (){
        return response()->download(public_path('/daniel.jpg'), 'face.jpg');
    })->name('download');
});


