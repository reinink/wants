<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function want()
    {
        return $this->belongsTo(Want::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
