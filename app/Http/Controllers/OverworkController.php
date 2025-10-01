<?php

namespace App\Http\Controllers;

use App\Models\Evidance;
use App\Models\Overwork;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverworkController
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
        return view('pages.overwork-request');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'date' => ['required', 'date'],
            'start' => ['required'],
            'finish' => ['required'],
            'desc' => ['required'],
            'user_id' => ['required'],
        ]);

        $status = $request->action === 'submit' ? 'review' : 'draft';

        try {
            DB::beginTransaction();

            $overwork = Overwork::create([
                'overwork_date' => $validate['date'],
                'start_overwork' => $validate['start'],
                'finished_overwork' => $validate['finish'],
                'task_description' => $validate['desc'],
                'request_status' => $status,
                'user_id' => $validate['user_id'],
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }

        $path = [];

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $path[] = $photo->store('evidance/photo', 'public');
            }
        }
        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $photo) {
                $path[] = $photo->store('evidance/video', 'public');
            }
        }

        foreach ($path as $p) {
            Evidance::create([
                'path' => $p,
                'overwork_id' => $overwork->id,
            ]);
        }

        if ($status === 'review') return redirect()->route('overwork.pending')->with('success', 'add data overwork successfully');
        else return redirect()->route('overwork.draft')->with('success', 'data overwork is draft');
    }

    /**
     * Display the specified resource.
     */
    public function show(Overwork $overwork) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Overwork $overwork)
    {
        $request = new RequestController;
        $evidance = [];
        foreach ($request->requestData() as $item) {
            if ($item->id === $overwork->id && $item->type === 'overwork') {
                foreach ($item->evidance as $e) {
                    $evidance[] = $e;
                }
                break;
            }
        }
        return view('pages.overwork-request', compact('evidance', 'overwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Overwork $overwork)
    {
        $path = [];

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $path[] = $photo->store('evidance/photo', 'public');
            }
        }
        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $photo) {
                $path[] = $photo->store('evidance/video', 'public');
            }
        }

        foreach ($path as $p) {
            Evidance::create([
                'path' => $p,
                'overwork_id' => $overwork->id,
            ]);
        }

        $validate = $request->validate([
            'date' => ['required', 'date'],
            'start' => ['required'],
            'finish' => ['required'],
            'desc' => ['required']
        ]);

        $status = $request->action === 'submit' ? 'review' : 'draft';

        $overwork->update([
            'overwork_date' => $validate['date'],
            'start_overwork' => $validate['start'],
            'finished_overwork' => $validate['finish'],
            'task_description' => $validate['desc'],
            'request_status' => $status,
        ]);

        if ($status === 'review') return redirect()->route('overwork.pending')->with('success', 'overwork updated successfully');
        else return redirect()->route('overwork.draft')->with('success', 'overwork draft updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Overwork $overwork)
    {
        try {
            $overwork->delete();
            return redirect()->back()->with('success', 'Overwork draft deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete overwork draft: ' . $e->getMessage()]);
        }
    }
}
