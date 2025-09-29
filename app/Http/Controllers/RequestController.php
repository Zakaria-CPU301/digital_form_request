<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use App\Models\Evidance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RequestController extends Controller
{
    //! disabled for optimization
    public function requestData()
    {
        $leaves = Leave::all()->sortByDesc('created_at')->map(function ($item) {
            $item->type = 'leave';
            return $item;
        });

        $overwork = Overwork::with('evidance')->orderByDesc('created_at')->get()->map(function ($item) {
            $item->type = 'overwork';
            return $item;
        });

        return $leaves->concat($overwork)->sortByDesc('created_at');
    }

    // public function showDraft(Request $request)
    // {
    //     $data = $this->requestData();
    //     $keyValue = $request->input('type');

    //     if (in_array($keyValue, ['leave', 'overwork'])) {
    //         $data = $data->where('type', $keyValue)
    //             ->where('request_status', 'draft')
    //             ->where('user_id', Auth::id());
    //     } else {
    //         $data = $data->where('request_status', 'draft')
    //             ->where('user_id', Auth::id())
    //             ->sortByDesc('created_at');
    //     }

    //     return view('view.users.draft', compact('data'));
    // }

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

    public function showOverworkData(Request $request)
    {
        $data = $this->requestData();
        $routeName = Route::currentRouteName();

        if (Auth::user()->role === 'user') {
            $data = $data->where('type', 'overwork')
                ->where('request_status', '!=', 'draft')
                ->where('user_id', Auth::id());
        } else {
            $data = $data->where('type', 'overwork')
                ->where('request_status', '!=', 'draft');
        }

        return view('view.users.overwork-data', compact('data'));
    }

    public function showLeaveData(Request $request)
    {
        $data = $this->requestData();
        $routeName = Route::currentRouteName();


        if (Auth::user()->role === 'user') {
            $data = $data->where('type', 'leave')
                ->where('request_status', '!=', 'draft')
                ->where('user_id', Auth::id());
        } else {
            $data = $data->where('type', 'leave')
                ->where('request_status', '!=', 'draft');
        }

        return view('view.users.leave-data', compact('data'));
    }

    public function showOverworkDraft(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'overwork')
            ->where('request_status', 'draft')
            ->where('user_id', Auth::id());

        return view('view.users.overwork-draft', compact('data'));
    }

    public function showLeaveDraft(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'leave')
            ->where('request_status', 'draft')
            ->where('user_id', Auth::id());

        return view('view.users.leave-draft', compact('data'));
    }

    public function showOverworkPending(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'overwork')
            ->where('request_status', 'review')
            ->where('user_id', Auth::id());

        return view('view.users.overwork-pending', compact('data'));
    }

    public function showOverworkAccepted(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'overwork')
            ->where('request_status', 'accepted')
            ->where('user_id', Auth::id());

        return view('view.users.overwork-accepted', compact('data'));
    }

    public function showOverworkRejected(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'overwork')
            ->where('request_status', 'rejected')
            ->where('user_id', Auth::id());

        return view('view.users.overwork-pending', compact('data'));
    }

    public function showLeavePending(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'leave')
            ->where('request_status', 'review')
            ->where('user_id', Auth::id());

        return view('view.users.leave-pending', compact('data'));
    }

    public function showLeaveAccepted(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'leave')
            ->where('request_status', 'accepted')
            ->where('user_id', Auth::id());

        return view('view.users.leave-accepted', compact('data'));
    }

    public function showLeaveRejected(Request $request)
    {
        $data = $this->requestData();

        $data = $data->where('type', 'leave')
            ->where('request_status', 'rejected')
            ->where('user_id', Auth::id());

        return view('view.users.leave-pending', compact('data'));
    }
}
