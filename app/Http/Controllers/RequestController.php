<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function showDraft()
    {
        $leaves = Leave::where('request_status', 'draft')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $item->type = 'leave';
                return $item;
            });

        $overworks = Overwork::where('request_status', 'draft')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $item->type = 'overwork';
                return $item;
            });
        $draft = $leaves->merge($overworks)->sortByDesc('created_at');

        return view('view.users.draft', ['draft' => $draft]);
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
        $recent = $overworks->merge($leaves)->sortByDesc('created_at');

        return view('view.users.recent-request', ['recent' => $recent]);
    }
}
