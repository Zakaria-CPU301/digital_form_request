<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManageAccountController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data = User::all()->sortByDesc('created_at');

        return view('view.admin.manage-account', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, string $status)
    {
        if ($status === 'suspended') {
            User::findOrFail($id)->update(['status_account' => 'suspended']);
        } elseif ($status === 'unsuspended') {
            User::findOrFail($id)->update(['status_account' => 'active']);
        }

        return redirect()->back()->with('success', [
            'title' => User::findOrFail($id)->name . ' is ' . $status,
            'message' => 'This overwork request has been approved.',
            'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Delete account is successfully');
    }
}
