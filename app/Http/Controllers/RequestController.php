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

    private function applyFilters($data, $month, $search)
    {
        if ($month && $month !== 'all') {
            $data = $data->filter(function ($item) use ($month) {
                return $item->created_at->format('m-Y') === $month;
            });
        }

        if ($search) {
            $searchLower = strtolower($search);
            $data = $data->filter(function ($item) use ($searchLower) {
                $reason = $item->reason ?? $item->task_description ?? '';
                return str_contains(strtolower($reason), $searchLower);
            });
        }

        return $data;
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
        $month = $request->input('month');
        $search = $request->input('search');

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
            $data = $this->applyFilters($data, $month, $search);
            return $routeName != 'dashboard'
                ? view('view.users.recent-request', compact('data', 'month', 'search'))
                : $data;
        } elseif (Auth::user()->role === 'admin') {
            $data = $this->applyFilters($data, $month, $search);
            return $data;
        }
    }

    public function showOverworkData(Request $request)
    {
        $data = $this->requestData();
        $routeName = Route::currentRouteName();
        $month = $request->input('month');
        $search = $request->input('search');

        if (Auth::user()->role === 'user') {
            $data = $data->where('type', 'overwork')
                ->where('request_status', '!=', 'draft')
                ->where('user_id', Auth::id());
        } else {
            $data = $data->where('type', 'overwork')
                ->where('request_status', '!=', 'draft');
        }

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.overwork-data', compact('data', 'month', 'search'));
    }

    public function showLeaveData(Request $request)
    {
        $data = $this->requestData();
        $routeName = Route::currentRouteName();
        $month = $request->input('month');
        $search = $request->input('search');

        if (Auth::user()->role === 'user') {
            $data = $data->where('type', 'leave')
                ->where('request_status', '!=', 'draft')
                ->where('user_id', Auth::id());
        } else {
            $data = $data->where('type', 'leave')
                ->where('request_status', '!=', 'draft');
        }

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.leave-data', compact('data', 'month', 'search'));
    }

    public function showOverworkDraft(Request $request)
    {
        $data = $this->requestData();
        $month = $request->input('month');
        $search = $request->input('search');

        $data = $data->where('type', 'overwork')
            ->where('request_status', 'draft')
            ->where('user_id', Auth::id());

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.overwork-draft', compact('data', 'month', 'search'));
    }

    public function showLeaveDraft(Request $request)
    {
        $data = $this->requestData();
        $month = $request->input('month');
        $search = $request->input('search');

        $data = $data->where('type', 'leave')
            ->where('request_status', 'draft')
            ->where('user_id', Auth::id());

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.leave-draft', compact('data', 'month', 'search'));
    }

    public function showOverworkPending(Request $request)
    {
        $data = $this->requestData();
        $month = $request->input('month');
        $search = $request->input('search');

        if (Auth::user()->role === 'admin') {
            $data = $data->where('type', 'overwork')
                ->where('request_status', 'review');
        } else {
            $data = $data->where('type', 'overwork')
                ->where('request_status', 'review')
                ->where('user_id', Auth::id());
        }

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.overwork-pending', compact('data', 'month', 'search'));
    }

    public function showOverworkAccepted(Request $request)
    {
        $data = $this->requestData();
        $month = $request->input('month');
        $search = $request->input('search');

        if (Auth::user()->role === 'admin') {
            $data = $data->where('type', 'overwork')
                ->where('request_status', 'accepted');
        } else {
            $data = $data->where('type', 'overwork')
                ->where('request_status', 'accepted')
                ->where('user_id', Auth::id());
        }

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.overwork-accepted', compact('data', 'month', 'search'));
    }

    public function showOverworkRejected(Request $request)
    {
        $data = $this->requestData();
        $month = $request->input('month');
        $search = $request->input('search');

        if (Auth::user()->role === 'admin') {
            $data = $data->where('type', 'overwork')
                ->where('request_status', 'rejected');
        } else {
            $data = $data->where('type', 'overwork')
                ->where('request_status', 'rejected')
                ->where('user_id', Auth::id());
        }

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.overwork-pending', compact('data', 'month', 'search'));
    }

    public function showLeavePending(Request $request)
    {
        $data = $this->requestData();
        $month = $request->input('month');
        $search = $request->input('search');

        if (Auth::user()->role === 'admin') {
            $data = $data->where('type', 'leave')
                ->where('request_status', 'review');
        } else {
            $data = $data->where('type', 'leave')
                ->where('request_status', 'review')
                ->where('user_id', Auth::id());
        }

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.leave-pending', compact('data', 'month', 'search'));
    }

    public function showLeaveAccepted(Request $request)
    {
        $data = $this->requestData();
        $month = $request->input('month');
        $search = $request->input('search');

        if (Auth::user()->role === 'admin') {
            $data = $data->where('type', 'leave')
                ->where('request_status', 'accepted');
        } else {
            $data = $data->where('type', 'leave')
                ->where('request_status', 'accepted')
                ->where('user_id', Auth::id());
        }

        $data = $this->applyFilters($data, $month, $search);

        return view('view.users.leave-accepted', compact('data', 'month', 'search'));
    }

    public function showLeaveRejected(Request $request)
    {
        $data = $this->requestData();

        if (Auth::user()->role === 'admin') {
            $data = $data->where('type', 'leave')
                ->where('request_status', 'rejected');
        } else {
            $data = $data->where('type', 'leave')
                ->where('request_status', 'rejected')
                ->where('user_id', Auth::id());
        }

        return view('view.users.leave-pending', compact('data'));
    }
}
