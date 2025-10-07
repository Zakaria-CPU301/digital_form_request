<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Exception;
use Illuminate\Http\Request;

class LeaveController
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.leave-request');
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
            'user_id' => ['required'],
        ]);

        $status = $request->action === 'submit' ? 'review' : 'draft';

        Leave::create([
            'start_leave' => $validate['start'],
            'finished_leave' => $validate['finish'],
            'reason' => $validate['reason'],
            'request_status' => $status,
            'user_id' => $validate['user_id']
        ]);

if ($status == 'draft') 
            return redirect()->route('leave.draft')->with('success', [
                'title' => 'Saved to draft!',
                'message' => 'Your leave request has been saved to draft.',
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i'),
                ]);
        

        if ($status === 'review') return redirect()->route('leave.review')->with('success', [
            'title' => 'Leave request Submitted!',
            'message' => 'Please wait for admin approval.',
            'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d H:i'),
            ]);
        else return redirect()->route('leave.draft')->with('success', 'data leave is draft');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        return view('pages.leave-request', compact('leave'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        $validate = $request->validate([
            'start' => ['required'],
            'finish' => ['required'],
            'reason' => ['required'],
        ]);

        $status = $request->action === 'submit' ? 'review' : 'draft';

        $leave->update([
            'start_leave' => $validate['start'],
            'finished_leave' => $validate['finish'],
            'reason' => $validate['reason'],
            'request_status' => $status,
        ]);

        if ($status === 'review') return redirect()->route('leave.review')->with('success', 'leave updated successfully');
        else return redirect()->route('leave.draft')->with('success', 'leave draft updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        try {
            $leave->delete();
            return redirect()->back()->with('success', 'Leave draft deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete leave draft: ' . $e->getMessage()]);
        }
    }
}
