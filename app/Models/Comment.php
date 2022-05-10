<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
   use SoftDeletes;
   
   use HasFactory;

   protected $fillable = ['content', 'user_id'];

   public function blogPost()
   {
        return $this->belongsTo(BlogPost::class);
   } 

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function scopeLatest(Builder $query)
   {
       return $query->orderBy(static::CREATED_AT, 'desc');
   }

   public static function boot()
    {
        parent::boot();

        static::creating(function (Comment $comment) {
            Cache::tags(['blog_post'])->forget("blog-post-{$comment->blog_post_id}");
            Cache::tags(['blog_post'])->forget('mostCommented');
        });

        // static::addGlobalScope(new LatestScope);
    }

}
