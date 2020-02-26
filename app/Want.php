<?php

namespace App;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Want extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('with_last_comment_id', function ($query) {
            $query->withLastCommentId();
        });
    }

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

    public function lastComment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function scopeWithLastCommentId($query)
    {
        $query->addSelect(['last_comment_id' => Comment::select('id')
            ->whereColumn('comments.want_id', 'wants.id')
            ->latest()
            ->take(1),
        ]);
    }

    public function scopeOrderByCategory($query)
    {
        $query->orderBy(
            Category::select('name')
                ->whereColumn('categories.id', 'wants.category_id')
        );
    }

    public function scopeOrderByLastCommentDate($query, $direction = 'desc')
    {
        $query->orderBy(
            Comment::select('created_at')
                ->whereColumn('comments.want_id', 'wants.id')
                ->latest()
                ->take(1),
            $direction
        );
    }

    public function scopeOrderByStatus($query)
    {
        $query->orderByRaw("
            case
                when status = 'Requested' then 1
                when status = 'Planned' then 2
                when status = 'Completed' then 3
            end
        ");
    }

    public function scopeOrderByActivity($query)
    {
        // total upvotes + (total comments * 2)

        $votes = Vote::selectRaw('count(*)')
            ->whereColumn('votes.want_id', 'wants.id')
            ->toSql();

        $comments = Comment::selectRaw('count(*)')
            ->whereColumn('comments.want_id', 'wants.id')
            ->toSql();

        $query->orderByRaw("($votes) + (($comments) * 2) desc");
        $query->selectRaw("($votes) + (($comments) * 2) as activity");
    }
}
