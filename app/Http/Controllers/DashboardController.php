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

        $recent = $controller->showRecent();

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
        $request->has('leave') ? $data['recent'] = $data['recent']->where('type', 'leave')
            : ($request->has('overwork') ? $data['recent'] = $data['recent']->where('type', 'overwork') : $data);

        $draftCount = $this->draftCount();
        $draft = ['count' => $draftCount];

        return view('dashboard', compact('data', 'draft'));
    }
}
