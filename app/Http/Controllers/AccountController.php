<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AccountController extends Controller
{
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
            'overwork_allowance' => 50
        ]);

        return redirect()->route('home')->with('success', 'Account berhasil ditambahkan!');
    }

    public function show(string $id): View
    {
        $account = Account::findOrFail($id);
        return view('layouts.account.show', compact('account'));
    }

    public function edit(string $id): View
    {
        $account = Account::findOrFail($id);
        return view('layouts.account.edit', compact('account'));
    }

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

    public function destroy(string $id): RedirectResponse
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account berhasil dihapus!');
    }
}
