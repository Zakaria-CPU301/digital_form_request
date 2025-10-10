<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RequestController;

class DashboardController extends Controller
{
    public function dataSubmitted()
    {
        $controller = new RequestController;
        $requestData = $controller->showRecent(request());

        $totalOverwork = Overwork::selectRaw('SUM(TIMESTAMPDIFF(HOUR, start_overwork, finished_overwork)) AS total_hours')
            ->where('user_id', Auth::id())
            ->get();

        $totalLeave = Leave::selectRaw('SUM(leave_period) AS leave_period')
            ->where('user_id', Auth::id())
            ->get();

        $approved = $requestData->where('request_status', 'accepted');
        $rejected = $requestData->where('request_status', 'rejected');
        $pending = $requestData->where('request_status', 'review');

        $result = $approved->concat($rejected)->concat($pending);
        return compact('totalOverwork', 'totalLeave', 'approved', 'rejected', 'pending', 'requestData', 'result');
    }

    public function dashboard(Request $request)
    {
        $data = $this->dataSubmitted();
        $month = $request->input('month');

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

         if ($month && $month !== 'all') {
            $data['requestData'] = $data['requestData']->filter(function ($item) use ($month) {
                if ($item->type === 'overwork') {
                    return Carbon::parse($item->overwork_date)->format('m-Y') === $month;
                } else {
                    return Carbon::parse($item->start_leave)->format('m-Y') === $month;
                }
            });
        }

        return view('dashboard', compact('data', 'filter', 'month'));
    }
}
