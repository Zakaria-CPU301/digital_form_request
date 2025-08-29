<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function showDraft()
    {
        $leaves = Leave::where('request_status', 'draft')->get()
            ->where('user_id', Auth::id())
            ->map(function ($item) {
                $item->type = 'leave';
                return $item;
            });

        $overworks = Overwork::where('request_status', 'draft')->get()
            ->where('user_id', Auth::id())
            ->map(function ($item) {
                $item->type = 'overwork';
                return $item;
            });
        $draft = $overworks->merge($leaves)->sortByDesc('created_at')->values();

        return view('view.users.draft', ['draft' => $draft]);
    }

    public function showRecent()
    {
        $leaves = Leave::where('request_status', '!=', 'draft')->get()
            ->where('user_id', Auth::id())
            ->map(function ($item) {
                $item->type = 'leave';
                return $item;
            });

        $overworks = Overwork::where('request_status', '!=', 'draft')->get()
            ->where('user_id', Auth::id())
            ->map(function ($item) {
                $item->type = 'overwork';
                return $item;
            });
        $draft = $overworks->merge($leaves)->sortByDesc('created_at')->values();

        return view('view.users.recent-request', ['draft' => $draft]);
    }
}
