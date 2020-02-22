<?php

namespace App\Http\Controllers;

use App\Want;
use Illuminate\Support\Facades\View;

class WantsController extends Controller
{
    public function index()
    {
        $wants = Want::query()
            ->with('category')
            ->withCount('votes', 'comments')
            ->orderBy('id')
            ->paginate();

        return View::make('wants', [
            'wants' => $wants,
        ]);
    }

    public function show(Want $want)
    {
        $want->load('comments.user');

        return View::make('want', [
            'want' => $want,
        ]);
    }
}
