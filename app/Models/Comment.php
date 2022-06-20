<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
   use SoftDeletes, Taggable;
   
   use HasFactory;

   protected $fillable = ['content', 'user_id'];

   public function commentable()
   {
        return $this->morphTo();
   } 

   public function user()
   {
       return $this->belongsTo(User::class);
   }

   public function scopeLatest(Builder $query)
   {
       return $query->orderBy(static::CREATED_AT, 'desc');
   }

}
