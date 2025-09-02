<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RequestController extends Controller
{
    public function showDraft()
    {
        $routeName = Route::currentRouteName();
        
        $leaves = Leave::where('request_status', 'draft')->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $item->type = 'leave';
                return $item;
            });

        $overworks = Overwork::where('request_status', 'draft')->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $item->type = 'overwork';
                return $item;
            });

        $all = $overworks->concat($leaves)->sortByDesc('created_at');


        if ($routeName === 'draft.overwork') {
            $draft = $overworks;
        } elseif ($routeName === 'draft.leave') {
            $draft = $leaves;
        } else {
            $draft = $all;
        }
        return view('view.users.draft', compact('draft'));
        
    }

    public function showRecent()
    {
        $leaves = Leave::where('request_status', '!=', 'draft')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $item->type = 'leave';
                return $item;
            });

        $overworks = Overwork::where('request_status', '!=', 'draft')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $item->type = 'overwork';
                return $item;
            });
        $recent = $overworks->concat($leaves)->sortByDesc('created_at');

        return view('view.users.recent-request', ['recent' => $recent]);
    }
}
