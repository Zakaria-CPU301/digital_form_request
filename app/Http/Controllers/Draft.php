<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Http\Request;

class Draft extends Controller
{
    public function index() {
        $leaves = Leave::where('request_status', 'draft')->get()
        ->map(function ($item) {
            $item->type = 'leave';
            return $item;
        });

        $overworks = Overwork::where('request_status', 'draft')->get()
        ->map(function ($item) {
            $item->type = 'overwork';
            return $item;
        });
        $draft = $overworks->merge($leaves)->sortByDesc('created_at');

        return view('view.users.draft', ['draft' => $draft]);
    }
}
