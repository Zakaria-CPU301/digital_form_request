<?php

namespace App\Http\Controllers;

use App\Models\Evidence;
use App\Models\Overwork;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OverworkController
{
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

            $path = [];
            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $path[] = $photo->store('evidence/photo', 'public');
                }
            }
            if ($request->hasFile('video')) {
                foreach ($request->file('video') as $photo) {
                    $path[] = $photo->store('evidence/video', 'public');
                }
            }

            foreach ($path as $p) {
                Evidence::create([
                    'path' => $p,
                    'overwork_id' => $overwork->id,
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }

        if ($status == 'draft')
            return redirect()->route('overwork.draft')->with('success', [
                'title' => 'Saved to draft!',
                'message' => 'Your overwork request has been saved to draft.',
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
            ]);

        if ($status === 'review') return redirect()->route('overwork.review')->with('success', [
            'title' => 'Overwork Submitted!',
            'message' => 'Please wait for admin approval.',
            'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
        ]);
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
        $evidence = [];
        foreach ($request->requestData() as $item) {
            if ($item->id === $overwork->id && $item->type === 'overwork') {
                foreach ($item->evidence as $e) {
                    $evidence[] = $e;
                }
                break;
            }
        }
        return view('pages.overwork-request', compact('evidence', 'overwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Overwork $overwork)
    {
        $validate = $request->validate([
            'date' => ['required', 'date'],
            'start' => ['required'],
            'finish' => ['required'],
            'desc' => ['required']
        ]);

        $status = $request->action === 'submit' ? 'review' : 'draft';

        try {
            $overwork->update([
                'overwork_date' => $validate['date'],
                'start_overwork' => $validate['start'],
                'finished_overwork' => $validate['finish'],
                'task_description' => $validate['desc'],
                'request_status' => $status,
            ]);

            $path = [];

            if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $photo) {
                    $path[] = $photo->store('evidence/photo', 'public');
                }
            }
            if ($request->hasFile('video')) {
                foreach ($request->file('video') as $video) {
                    $path[] = $video->store('evidence/video', 'public');
                }
            }

            foreach ($path as $p) {
                Evidence::create([
                    'path' => $p,
                    'overwork_id' => $overwork->id,
                ]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Draft updated successfully']);
            }

            if ($status == 'draft')
                return redirect()->route('overwork.draft')->with('success', [
                    'title' => 'Draft Updated!',
                    'message' => 'Your overwork request has been draft updated.',
                    'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
                ]);

            if ($status === 'review') return redirect()->route('overwork.review')->with('success', [
                'title' => 'Overwork Submitted!',
                'message' => 'Please wait for admin approval.',
                'time' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d | H:i'),
            ]);
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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

    /**
     * Delete a specific evidence.
     */
    public function deleteEvidence(Evidence $evidence)
    {
        try {
            $evidence->delete();
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
