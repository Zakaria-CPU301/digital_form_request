<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;
use Illuminate\Validation\Rules\Exists;

class ManageDataController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $requestData = new RequestController;
        $status = $request->input('status');
        $month = $request->input('month');
        $search = $request->input('search');
        $data = $requestData->requestData()->where('request_status', '!=', 'draft');

        if ($status && $status !== 'submitted') {
            $data = $data->where('request_status', $status);
        }
        if ($month && $month !== 'all') {
            $data = $data->filter(function ($item) use ($month) {
                return Carbon::parse($item->start_leave ?? $item->overwork_date ?? '')->format('m-Y') === $month;
            });
        }
        if ($search) {
            $data = $data->filter(function ($item)  use ($search, $month) {
                return stripos($item->type ?? '', $search) !== false ||
                    stripos($item->user->name ?? '', $search) !== false ||
                    stripos($item->reason ?? $item->task_description ?? '', $search) !== false ||
                    stripos($item->request_status ?? '', $search) !== false;
            });
        }

        return view('view.admin.manage-data', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, string $leaveId, string $userId)
    {
        if ($request->has('rejected')) {
            $status = $request->input('rejected');
            $status === 'overwork' ?
                Overwork::where('id', $leaveId)->update(['request_status' => 'rejected'])
                : Leave::where('id', $leaveId)->update(['request_status' => 'rejected']);

            return redirect()->back()->with('success', [
                'title' => $status . ' Rejected!',
                'message' => 'This overwork request has been rejected.',
            ]);
        }

        $totalLeave = (int) Leave::where('user_id', $userId)->where('request_status', 'approved')->sum('leave_period');
        $allowance = User::findOrFail($userId)->overwork_allowance;
        $newApproval = (int) $request['this_leave_period'];
        $validateBalanceApproval = $totalLeave + $newApproval;
        if ($validateBalanceApproval > $allowance * 8) {
            return redirect()->back()->with('fail', [
                'title' => 'Leave period exceeds allowance',
                'message' => 'The total leave period including this request exceeds the user\'s leave allowance.',
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
            ]);
        }
        if ($request->has('approved')) {
            $status = $request->input('approved');
            $status === 'overwork' ?
                Overwork::where('id', $leaveId)->update(['request_status' => 'approved'])
                : Leave::where('id', $leaveId)->update(['request_status' => 'approved']);

            return redirect()->back()->with('success', [
                'title' => $status . ' Approved!',
                'message' => "This {$status} request has been approved.",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
