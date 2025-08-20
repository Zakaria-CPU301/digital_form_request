<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $accounts = Account::latest()->paginate(10);
        return view('layouts.account.index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.addUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:accounts,email'],
            'phone_number' => ['required', 'string', 'max:30'],
            'position' => ['required', 'in:a,b,c,d'],
            'job' => ['required', 'in:a,b,c,d'],
            'role' => ['required', 'in:admin,user']
        ]);

        Account::create([
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'position' => $validated['position'],
            'job' => $validated['job'],
            'roles' => $validated['role'],
            'overtime_allowance' => 50
        ]);

        return redirect()->route('home')->with('success', 'Account berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $account = Account::findOrFail($id);
        return view('layouts.account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $account = Account::findOrFail($id);
        return view('layouts.account.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $account = Account::findOrFail($id);

        $validated = $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:accounts,email,' . $id],
            'phone_number' => ['required', 'string', 'max:30'],
            'position' => ['required', 'in:a,b,c,d'],
            'job' => ['required', 'in:a,b,c,d'],
            'roles' => ['required', 'in:admin,user']
        ]);

        $account->update([
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'position' => $validated['position'],
            'job' => $validated['job'],
            'roles' => $validated['roles']
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account berhasil dihapus!');
    }
}
