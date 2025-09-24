<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RequestController;

class DashboardController extends Controller
{
    public function dataSubmitted()
    {
        $controller = new RequestController;
        $allData = $controller->requestData();

        $approved = $allData->where('request_status', 'accepted')->count();

        $rejected = $allData->where('request_status', 'rejected')->count();

        $pending = $allData->where('request_status', 'review')->count();

        $recent = $controller->showRecent(request());

        // dd($recent);

        return compact('approved', 'rejected', 'pending', 'recent');
    }

    public function draftCount()
    {
        $controller = new RequestController;
        $allData = $controller->requestData();
        $drafts = $allData->where('request_status', 'draft')->where('user_id', Auth::id())->count();
        return $drafts;
    }

    public function dashboard(Request $request)
    {
        $data = $this->dataSubmitted();
        $filter = $request->input('type');
        $month = $request->input('month');
        $search = $request->input('search');

        // Apply type filter
        if (in_array($filter, ['leave', 'overwork'])) {
            $data['recent'] = $data['recent']->where('type', $filter);
        }

        // Apply month filter
        if ($month && $month !== 'all') {
            $data['recent'] = $data['recent']->filter(function ($item) use ($month) {
                return $item->created_at->format('m-Y') === $month;
            });
        }

        // Apply search filter
        if ($search) {
            $data['recent'] = $data['recent']->filter(function ($item) use ($search) {
                $searchLower = strtolower($search);
                $reason = $item->reason ?? $item->task_description ?? '';

                return str_contains(strtolower($reason), $searchLower);
            });
        }

        $draftCount = $this->draftCount();
        $draft = ['count' => $draftCount];

        return view('dashboard', compact('data', 'draft', 'filter', 'month', 'search'));
    }
}
