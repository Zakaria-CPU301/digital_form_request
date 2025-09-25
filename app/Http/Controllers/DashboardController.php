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
        $requestData = $controller->showRecent(request());

        $approved = $requestData->where('request_status', 'accepted')->count();

        $rejected = $requestData->where('request_status', 'rejected')->count();

        $pending = $requestData->where('request_status', 'review')->count();


        return compact('approved', 'rejected', 'pending', 'requestData');
    }

    public function dashboard(Request $request)
    {
        $data = $this->dataSubmitted();
        $month = $request->input('month');
        $search = $request->input('search');

        // Apply type filter
        if (Auth::user()->role === 'user') {
            $filter = $request->input('type');
            if (in_array($filter, ['leave', 'overwork'])) {
                $data['requestData'] = $data['requestData']->where('type', $filter)->take(4);
            } else {
                $data['requestData'] = $data['requestData']->take(4);
            }
        } elseif (Auth::user()->role === 'admin') {
            $filter = $request->input('status');
            $data['requestData'] = $data['requestData']->where('request_status', $filter ?? 'review')->take(8);
        }

        // Apply month filter
        if ($month && $month !== 'all') {
            $data['requestData'] = $data['requestData']->filter(function ($item) use ($month) {
                return $item->created_at->format('m-Y') === $month;
            });
        }

        // Apply search filter
        if ($search) {
            $data['requestData'] = $data['requestData']->filter(function ($item) use ($search) {
                $searchLower = strtolower($search);
                $reason = $item->reason ?? $item->task_description ?? '';

                return str_contains(strtolower($reason), $searchLower);
            });
        }

        return view('dashboard', compact('data', 'filter', 'month', 'search'));
    }
}
