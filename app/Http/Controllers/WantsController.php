<?php

namespace App\Http\Controllers;

use App\Want;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class WantsController extends Controller
{
    public function index()
    {
        $statuses = Want::getQuery()
            ->selectRaw("count(case when status = 'Requested' then 1 end) as requested")
            ->selectRaw("count(case when status = 'Planned' then 1 end) as planned")
            ->selectRaw("count(case when status = 'Completed' then 1 end) as completed")
            ->first();

        $wants = Want::query()
            ->with('category', 'lastComment.user')
            ->withCount('votes', 'comments')
            ->when(Request::input('sort'), function ($query, $sort) {
                switch ($sort) {
                    case 'category': return $query->orderByCategory();
                    case 'last_comment': return $query->orderByLastCommentDate();
                    case 'status': return $query->orderByStatus();
                    case 'activity': return $query->orderByActivity();
                }
            })
            ->orderBy('id')
            ->paginate();

        return View::make('wants', [
            'statuses' => $statuses,
            'wants' => $wants,
        ]);
    }

    public function show(Want $want)
    {
        $want->load('comments.user:id,name,photo');
        $want->comments->each->setRelation('want', $want);

        return View::make('want', [
            'want' => $want,
        ]);
    }
}
