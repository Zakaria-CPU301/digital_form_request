<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RequestController extends Controller
{
    public function requestData()
    {
        $leaves = Leave::all()->sortByDesc('created_at')->map(function ($item) {
            $item->type = 'leave';
            return $item;
        });
        $overwork = Overwork::all()->sortByDesc('created_at')->map(function ($item) {
            $item->type = 'overwork';
            return $item;
        });
        return $leaves->concat($overwork)->sortByDesc('created_at');
    }

    public function showDraft(Request $request)
    {
        $data = $this->requestData();
        $keyValue = $request->input('type');

        if (in_array($keyValue, ['leave', 'overwork'])) {
            $data = $data->where('type', $keyValue)
                ->where('request_status', 'draft')
                ->where('user_id', Auth::id());
        } else {
            $data = $data->where('request_status', 'draft')
                ->where('user_id', Auth::id())
                ->sortByDesc('created_at');
        }

        return view('view.users.draft', compact('data'));
    }

    public function showRecent(Request $request)
    {
        $data = $this->requestData();
        $routeName = Route::currentRouteName();
        $keyValue = $request->input('type');

        if (Auth::user()->role === 'user') {
            if (in_array($keyValue, ['leave', 'overwork'])) {
                $data = $data->where('type', $keyValue)
                ->where('request_status', '!=', 'draft')
                ->where('user_id', Auth::id());
            } else {
                $data = $data->where('request_status', '!=', 'draft')
                ->where('user_id', Auth::id())
                ->sortByDesc('created_at');
            }
            return $routeName != 'dashboard' 
            ? view('view.users.recent-request', compact('data')) 
            : $data;
        } elseif (Auth::user()->role === 'admin') {
            return $data;
        }
    }
}
