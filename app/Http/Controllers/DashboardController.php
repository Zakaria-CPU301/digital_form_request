<?php

namespace App\Http\Controllers;

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function total() {
        $controller = new RequestController;
        $allData = $controller->requestData();

        $approved = $allData->where('request_status', 'accepted')->count();
        
        $rejected = $allData->where('request_status', 'rejected')->count();

        $pending = $allData->where('request_status', 'review')->count();

        return compact('approved', 'rejected', 'pending');
    }
    
    public function recent() {
        $controller = new RequestController;
        $recent = $controller->showRecent();
        return compact('recent');
    }

    public function draftCount() {
        $controller = new RequestController;
        $allData = $controller->requestData();
        $drafts = $allData->where('request_status', 'draft')->where('user_id', Auth::id())->count();
        return $drafts;
    }

    public function dashboard() {
        $total = $this->total();
        $recent = $this->recent();
        $draftCount = $this->draftCount();
        $draft = ['count' => $draftCount];

        return view('dashboard', compact('total', 'recent', 'draft'));
    }

}
