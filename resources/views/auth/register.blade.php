@push('styles')
<style>
    .ts-wrapper {
        border: none;
    }
    
    .ts-wrapper .ts-control {
        padding-inline: 11px;
        padding-block: 13px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
    }

    .ts-wrapper.focus .ts-control {
        border-color: #6366f1;
        border-width: 2px;
    }

    /* .ts-wrapper .ts-control .item,
    .ts-wrapper .ts-control div {
        font-size: 16px;
    } */

</style>
@endpush @extends('layouts.tables') @section('content') @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('register') }}" autocomplete="off">
    @csrf

    <div
        class="p-6 bg-[#F0F3F8] rounded-2xl shadow-lg max-w-full mx-auto text-black"
        :class="$el.closest('[x-data]')?.__x.$data.sidebarOpen ? 'max-w-full' : 'max-w-6xl'"
    >
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-[#042E66] mb-6">
            Add Employee Account
        </h2>

        <!-- Subtitle -->
        <h3 class="font-semibold text-[#042E66] mb-4">Employee Information</h3>

        <div
            :class="$el.closest('[x-data]')?.__x.$data.sidebarOpen ? 'overflow-x-auto' : ''"
            class="w-full"
        >
            <table class="w-full border-collapse min-w-[800px]">
                <tbody>
                    <tr class="">
                        <!-- Left Column -->
                        <td
                            class="pr-8 w-1/2 align-top"
                            :class="$el.closest('[x-data]')?.__x.$data.sidebarOpen ? 'pr-4' : 'pr-8'"
                        >
                            <!-- Name -->
                            <div class="mb-4">
                                <label
                                    for="name"
                                    class="font-semibold text-sm block mb-1"
                                    >Name</label
                                >
                                <x-text-input
                                    placeholder="New User's Fullname"
                                    id="name"
                                    type="text"
                                    name="name"
                                    :value="old('name')"
                                    required
                                    autofocus
                                    class="w-full rounded border px-3 py-2"
                                />
                                <x-input-error
                                    :messages="$errors->get('name')"
                                    class="mt-1 text-red-600"
                                />
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label
                                    for="email"
                                    class="font-semibold text-sm block mb-1"
                                    >Email</label
                                >
                                <x-text-input
                                    placeholder="New User's Email"
                                    id="email"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    class="w-full rounded border border-black px-3 py-2"
                                />
                                <x-input-error
                                    :messages="$errors->get('email')"
                                    class="mt-1 text-red-600"
                                />
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label
                                    for="password"
                                    class="font-semibold text-sm block mb-1"
                                    >Password</label
                                >
                                <x-text-input
                                    placeholder="Create Password"
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="w-full rounded border border-black px-3 py-2"
                                />
                                <x-input-error
                                    :messages="$errors->get('password')"
                                    class="mt-1 text-red-600"
                                />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label
                                    for="password_confirmation"
                                    class="font-semibold text-sm block mb-1"
                                    >Confirm Password</label
                                >
                                <x-text-input
                                    placeholder="confirm the password"
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="w-full rounded border border-black px-3 py-2"
                                />
                                <x-input-error
                                    :messages="$errors->get('password_confirmation')"
                                    class="mt-1"
                                />
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-4">
                                <label
                                    for="phone"
                                    class="font-semibold text-sm block mb-1"
                                    >Phone Number</label
                                >
                                <x-text-input
                                    placeholder="New User's Phone Number"
                                    id="phone"
                                    type="text"
                                    name="phone_number"
                                    :value="old('phone_number')"
                                    required
                                    class="w-full rounded border border-black px-3 py-2"
                                />
                                <x-input-error
                                    :messages="$errors->get('phone')"
                                    class="mt-1 text-red-600"
                                />
                            </div>
                        </td>

                        <!-- Right Column -->
                        <td
                            class="align-top w-1/2"
                            :class="$el.closest('[x-data]')?.__x.$data.sidebarOpen ? 'pl-4' : ''"
                        >
                            <!-- Position -->
                            <div class="mb-4">
                                <label
                                    for="position"
                                    class="font-semibold text-sm block mb-1"
                                    >Position</label
                                >
                                <select
                                    placeholder="Select New User Position"
                                    id="position"
                                    name="position"
                                    required
                                    class="text-lg w-full rounded border border-black px-0 py-0 shadow-sm"
                                >
                                    <option disabled hidden selected></option>
                                    <option value="Admin">Admin</option>
                                    <option value="Concept Art and Illustration">Concept Art and Illustration</option>
                                    <option value="Web Programmer">Web Programmer</option>
                                    <option value="3D Artist">3D Artist</option>
                                </select>
                                <x-input-error
                                    :messages="$errors->get('position')"
                                    class="mt-1 text-red-600"
                                />
                            </div>

                            <!-- Department -->
                            <div class="mb-4">
                                <label
                                    for="department"
                                    class="font-semibold text-sm block mb-1"
                                    >Department</label
                                >
                                <select
                                    placeholder="Select New User Department"
                                    id="department"
                                    name="department"
                                    required
                                    class="w-full rounded border border-black px-0 py-0 shadow-sm"
                                >
                                    <option disabled hidden selected></option>
                                    <option value="Admin">Admin</option>
                                    <option value="Digital Art">
                                        Digital Art
                                    </option>
                                    <option value="IT">IT</option>
                                    <option value="Animasi">Animation</option>
                                </select>
                                <x-input-error
                                    :messages="$errors->get('department')"
                                    class="mt-1 text-red-600"
                                />
                            </div>

                            <!-- Role -->
                            <div class="mb-4">
                                <label
                                    for="role"
                                    class="font-semibold text-sm block mb-1"
                                    >Role</label
                                >
                                <select
                                    placeholder="Select New User Role"
                                    id="role"
                                    name="role"
                                    required
                                    class="w-full rounded border border-black px-0 py-0 shadow-sm"
                                >
                                    <option disabled hidden selected></option>
                                    <option value="admin">admin</option>
                                    <option value="user">user</option>
                                </select>
                                <x-input-error
                                    :messages="$errors->get('role')"
                                    class="mt-1 text-red-600"
                                />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

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
<script>
(function () {
  function initToggle(btnId, inputId, labelShow, labelHide) {
    const btn = document.getElementById(btnId);
    const input = document.getElementById(inputId);
    if (!btn || !input) return;

    const eyeSVG = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z"/></svg>';
    const eyeOffSVG = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/><path stroke-linecap="round" stroke-linejoin="round" d="M10.477 10.477A3 3 0 0113.523 13.523"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.88 6.88C8.155 6.47 9.571 6.29 11 6.29c4.477 0 8.268 2.943 9.542 7-0.34 1.082-0.9 2.07-1.642 2.923M3.17 8.53A9.953 9.953 0 002.458 12c1.274 4.057 5.065 7 9.542 7 1.429 0 2.845-.18 4.121-.59"/></svg>';

    btn.innerHTML = eyeSVG;

    btn.addEventListener('click', e => {
      e.preventDefault();
      const hidden = input.type === 'password';
      input.type = hidden ? 'text' : 'password';
      btn.innerHTML = hidden ? eyeOffSVG : eyeSVG;
      btn.setAttribute('aria-label', hidden ? labelHide : labelShow);
      input.focus({ preventScroll: true });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      initToggle('togglePassword', 'password', 'Show password', 'Hide password');
      initToggle('togglePasswordConfirm', 'password_confirmation', 'Show confirm password', 'Hide confirm password');
    });
  } else {
    initToggle('togglePassword', 'password', 'Show password', 'Hide password');
    initToggle('togglePasswordConfirm', 'password_confirmation', 'Show confirm password', 'Hide confirm password');
  }
})();
</script>

@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new TomSelect('#position', {
            create: false,
        });
        new TomSelect('#department', {
            create: false,
        });
        new TomSelect('#role', {
            create: false,
        });
    });
</script>
