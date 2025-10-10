<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

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
        // $arr = [
        //     $request->startDate,
        //     (float) $request->manyDays
        // ];
        // dump($arr);
        // dump($request->all());
        // dd();
        $validate = $request->validate([
            'start_leave' => ['required'],
            'many_days' => 'nullable|numeric|required_without_all:many_hours',
            'many_hours' => 'nullable|numeric|required_without_all:many_days',
            'reason' => ['required'],
            'user_id' => ['required'],
        ], [
            'many_days.required_without_all' => 'Please fill at least one of Days or Hours.',
            'many_hours.required_without_all' => 'Please fill at least one of Days or Hours.',
        ]);

        if ($validate['many_days'] == '0' && $validate['many_hours'] == '0') {
            return back()
                ->withErrors(['many_days' => 'Either days or hours must be greater than 0.'])
                ->withErrors(['many_hours' => 'Either days or hours must be greater than 0.'])
                ->withInput();
        }

        $totalPeriod = (float) ($validate['many_days'] * 8) + $validate['many_hours'];
        $status = $request->action === 'submit' ? 'review' : 'draft';

        Leave::create([
            'start_leave' => $validate['start_leave'],
            'leave_period' => (int) $totalPeriod,
            'reason' => $validate['reason'],
            'request_status' => $status,
            'user_id' => $validate['user_id']
        ]);

        if ($status == 'draft')
            return redirect()->route('leave.draft')->with('success', [
                'title' => 'Saved to draft!',
                'message' => 'Your leave request has been saved to draft.',
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
            ]);

        if ($status === 'review') return redirect()->route('leave.review')->with('success', [
            'title' => 'Leave request Submitted!',
            'message' => 'Please wait for admin approval.',
            'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
        ]);
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

        if ($status == 'draft')
            return redirect()->route('leave.draft')->with('success', [
                'title' => 'Draft updated!',
                'message' => 'Your leave request has been draft updated.',
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
            ]);

        if ($status === 'review') return redirect()->route('leave.review')->with('success', [
            'title' => 'Leave request Submitted!',
            'message' => 'Please wait for admin approval.',
            'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
        ]);
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
