<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.leave_request');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'start' => ['required'],
            'finish' => ['required'],
            'reason' => ['required'],
        ]);

        $status = $request->action === 'submit' ? 'submitted' : 'draft';

        Leave::create([
            'start_leave' => $validate['start'],
            'finished_leave' => $validate['finish'],
            'reason' => $validate['reason'],
            'request_status' => $status,
            'account_id' => 1
        ]);

        if ($status === 'submitted') return redirect()->route('dashboard')->with('success', 'add data leave successfully');
        else return redirect()->route('draft')->with('success', 'data leave is draft');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
