<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RequestController extends Controller
{
    public function requestData()
    {
        $leaves = Leave::all()->map(function ($item) {
            $item->type = 'leave';
            return $item;
        });
        $overwork = Overwork::all()->map(function ($item) {
            $item->type = 'overwork';
            return $item;
        });
        return $leaves->concat($overwork);
    }

    public function showDraft()
    {
        $allData = $this->requestData();
        $routeName = Route::currentRouteName();

        $leaves = $allData->where('type', 'leave')
            ->where('request_status', 'draft')
            ->where('user_id', Auth::id());

        $overworks = $allData->where('type', 'overwork')
            ->where('request_status', 'draft')
            ->where('user_id', Auth::id());

        $all = $overworks->concat($leaves)->sortByDesc('created_at');


        $routeName === 'draft.overwork' ? $draft = $overworks
            : ($routeName === 'draft.leave' ? $draft = $leaves
                : $draft = $all);

        return view('view.users.draft', compact('draft'));
    }

    public function showRecent()
    {
        $allData = $this->requestData();
        $routeName = Route::currentRouteName();

        $leaves = $allData->where('type', 'leave')
            ->where('request_status', '!=', 'draft')
            ->where('user_id', Auth::id());

        $overworks = $allData->where('type', 'overwork')
            ->where('request_status', '!=', 'draft')
            ->where('user_id', Auth::id());

        $all = $overworks->concat($leaves)->sortByDesc('created_at')->values();

        $routeName === 'recent.overwork' ? $recent = $overworks
            : ($routeName === 'recent.leave' ? $recent = $leaves
                : $recent = $all);

        if ($routeName != 'dashboard') return view('view.users.recent-request', compact('recent'));
        return $all->take(4);
    }
}
