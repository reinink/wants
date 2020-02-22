<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Want extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->oldest();
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function url()
    {
        return URL::route('want', [
            $this->id,
            $this->category->slug,
            $this->slug,
        ]);
    }
}
