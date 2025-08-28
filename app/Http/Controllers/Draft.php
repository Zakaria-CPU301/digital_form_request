<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Http\Request;

class Draft extends Controller
{
    public function index() {
        $leave = Leave::where('request_status', 'draft')->get();
        $overwork = Overwork::where('request_status', 'draft');
        
    }
}
