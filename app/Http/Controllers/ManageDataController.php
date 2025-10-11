<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Overwork;
use Illuminate\Http\Request;
use App\Http\Controllers\RequestController;

class ManageDataController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $requestData = new RequestController;
        $filter = $request->input('status');
        $month = $request->input('month');
        $search = $request->input('search');
        $data = $requestData->requestData()
            ->where('request_status', '!=', 'draft')
            ->where('request_status', $filter ?? 'review');

        // Apply filters
        if ($month && $month !== 'all') {
            $data = $data->filter(function ($item) use ($month) {
                return $item->created_at->format('m-Y') === $month;
            });
        }

        if ($search) {
            $searchLower = strtolower($search);
            $data = $data->filter(function ($item) use ($searchLower) {
                $reason = $item->reason ?? $item->task_description ?? '';
                return str_contains(strtolower($reason), $searchLower);
            });
        }

        return view('view.admin.manage-data', compact('data', 'month', 'search'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, string $id)
    {
        if ($request->has('rejected')) {
            $status = $request->input('rejected');
            $status === 'overwork' ?
                Overwork::where('id', $id)->update(['request_status' => 'rejected'])
                : Leave::where('id', $id)->update(['request_status' => 'rejected']);

            return redirect()->back()->with('success', [
                'title' => $status . ' Rejected!',
                'message' => 'This overwork request has been rejected.',
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
            ]);
        }

        if ($request->has('approved')) {
            $status = $request->input('approved');
            $status === 'overwork' ?
                Overwork::where('id', $id)->update(['request_status' => 'approved'])
                : Leave::where('id', $id)->update(['request_status' => 'approved']);

            return redirect()->back()->with('success', [
                'title' => $status . ' Approved!',
                'message' => "This {$status} request has been approved.",
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
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
