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
        $data = $requestData->requestData()
            ->where('request_status', '!=', 'draft')
            ->where('request_status', $filter ?? 'review');

        return view('view.admin.manage-data', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, string $id)
    {
        if ($request->has('rejected')) {
            $request->input('rejected') === 'overwork' ?
                Overwork::where('id', $id)->update(['request_status' => 'rejected'])
                : Leave::where('id', $id)->update(['request_status' => 'rejected']);
        }

        if ($request->has('accepted')) {
            $request->input('accepted') === 'overwork' ?
                Overwork::where('id', $id)->update(['request_status' => 'accepted'])
                : Leave::where('id', $id)->update(['request_status' => 'accepted']);
        }

        return redirect()->back()->with('success', 'Status updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
