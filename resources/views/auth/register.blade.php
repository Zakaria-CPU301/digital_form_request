@extends('layouts.tables')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="p-6 bg-[#F0F3F8] rounded-2xl shadow-lg max-w-6xl mx-auto text-black">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-[#042E66] mb-6">
            Add Employee Account
        </h2>

        <!-- Subtitle -->
        <h3 class="font-semibold text-[#042E66] mb-4">
            Employee Information
        </h3>

        <table class="w-full border-collapse">
            <tbody>
                <tr>
                    <!-- Left Column -->
                    <td class="pr-8 w-1/2 align-top">
                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="font-semibold text-sm block mb-1">Name</label>
                            <x-text-input 
                                id="name" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name"
                                class="w-full rounded border border-black px-3 py-2" 
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-600" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="font-semibold text-sm block mb-1">Email</label>
                            <x-text-input 
                                id="email" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username"
                                class="w-full rounded border border-black px-3 py-2" 
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="font-semibold text-sm block mb-1">Password</label>
                            <x-text-input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                class="w-full rounded border border-black px-3 py-2" 
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="font-semibold text-sm block mb-1">Confirm Password</label>
                            <x-text-input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                class="w-full rounded border border-black px-3 py-2" 
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-600" />
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                            <label for="phone" class="font-semibold text-sm block mb-1">Phone Number</label>
                            <x-text-input 
                                id="phone" 
                                type="text" 
                                name="phone_number" 
                                :value="old('phone_number')" 
                                required 
                                autocomplete="tel"
                                class="w-full rounded border border-black px-3 py-2" 
                            />
                            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-red-600" />
                        </div>
                    </td>

                    <!-- Right Column -->
                    <td class="align-top w-1/2">
                        <!-- Position -->
                        <div class="mb-4">
                            <label for="position" class="font-semibold text-sm block mb-1">Position</label>
                            <select 
                                id="position" 
                                name="position" 
                                required 
                                autocomplete="position"
                                class="w-full rounded border border-black px-3 py-2"
                            >
                                <option disabled hidden selected>position</option>
                                <option value="Admin">Admin</option>
                                <option value="Concept Art and Illustration">Concept Art and Illustration</option>
                                <option value="Web Programmer">Web Programmer</option>
                                <option value="3D Artist">3D Artist</option>
                            </select>
                            <x-input-error :messages="$errors->get('position')" class="mt-1 text-red-600" />
                        </div>

                        <!-- Department -->
                        <div class="mb-4">
                            <label for="department" class="font-semibold text-sm block mb-1">Department</label>
                            <select 
                                id="department" 
                                name="department" 
                                required 
                                autocomplete="department"
                                class="w-full rounded border border-black px-3 py-2"
                            >
                                <option disabled hidden selected>department</option>
                                <option value="Admin">Admin</option>
                                <option value="Digital Art">Digital Art</option>
                                <option value="IT">IT</option>
                                <option value="Animation">Animation</option>
                            </select>
                            <x-input-error :messages="$errors->get('department')" class="mt-1 text-red-600" />
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="font-semibold text-sm block mb-1">Role</label>
                            <select 
                                id="role" 
                                name="role" 
                                required 
                                autocomplete="role"
                                class="w-full rounded border border-black px-3 py-2"
                            >
                                <option disabled hidden selected>role</option>
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-1 text-red-600" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Submit Button -->
        <div class="text-right mt-6">
            <x-primary-button class="inline-flex items-center gap-2">
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="h-5 w-5 text-white" 
                    fill="none"
                    viewBox="0 0 24 24" 
                    stroke="currentColor" 
                    stroke-width="2"
                >
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4" 
                    />
                </svg>
                Add Account
            </x-primary-button>
        </div>
    </div>
</form>
@endsection
