<?php

namespace App\Http\Controllers;

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
            'user_id' => ['required']
        ]);
        
        $status = $request->action === 'submit' ? 'submitted' : 'draft';

        try {
            DB::beginTransaction();

            Overwork::create([
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

        if ($status === 'submitted') return redirect()->route('dashboard')->with('success', 'add data leave successfully');
        else return redirect()->route('draft')->with('success', 'data leave is draft');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Overwork $overwork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Overwork $overwork)
    {
        //
    }
}
