<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function blogPosts () 
    {
       // return $this->belongsToMany(BlogPost::class)->withTimestamps()->as('tagged');
       return $this->morphByMany(BlogPost::class, 'taggable')->withTimestamps()->as('tagged');
    }
}
