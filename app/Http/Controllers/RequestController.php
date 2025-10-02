<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Evidance;
use App\Models\Overwork;
use Illuminate\Support\Str;
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
            if ($routeName != 'dashboard') {
                if (Str::before($routeName, '.') === 'overwork') {
                    $suffix = Str::after($routeName, 'overwork.');
                    $data = $this->applyFilters($data, $month, $search)->where('type', 'overwork')->where('user_id', Auth::id());
                    if (in_array($suffix, ['review', 'accepted', 'rejected', 'draft'])) {
                        $data = $data->where('request_status', $suffix);
                    }
                    return view('view.users.overwork-data', compact('data'));
                } else {
                    $suffix = Str::after($routeName, 'leave.');
                    $data = $this->applyFilters($data, $month, $search)->where('type', 'leave')->where('user_id', Auth::id());
                    if (in_array($suffix, ['review', 'accepted', 'rejected', 'draft'])) {
                        $data = $data->where('request_status', $suffix);
                    }
                    return view('view.users.leave-data', compact('data'));
                }
            } else {
                $data = $this->applyFilters($data, $month, $search)->where('request_status', '!=', 'draft')->where('user_id', Auth::id());
                return $data;
            }
        } elseif (Auth::user()->role === 'admin') {
            if ($routeName != 'dashboard') {
                if (Str::before($routeName, '.') === 'overwork') {
                    $suffix = Str::after($routeName, 'overwork.');
                    $data = $this->applyFilters($data, $month, $search)->where('type', 'overwork')->where('request_status', '!=', 'draft');
                    if (in_array($suffix, ['review', 'accepted', 'rejected', 'draft'])) {
                        $data = $data->where('request_status', $suffix);
                    }
                    return view('view.users.overwork-data', compact('data'));
                } else {
                    $suffix = Str::after($routeName, 'leave.');
                    $data = $this->applyFilters($data, $month, $search)->where('type', 'leave')->where('request_status', '!=', 'draft');
                    if (in_array($suffix, ['review', 'accepted', 'rejected', 'draft'])) {
                        $data = $data->where('request_status', $suffix);
                    }
                    return view('view.users.leave-data', compact('data'));
                }
            } else {
                $data = $this->applyFilters($data, $month, $search);
                return $data;
            }
        }
    }
}
