@extends('layouts.tables')

@section('content')
<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <h2 class="text-2xl font-bold text-[#012967] mb-4">Manage Account</h2>

    <div id="filter" class="flex items-center">
        @php
            $activeToggle = request('status', 'pending');
        @endphp
        {{-- Tabs --}}
        <form id="type" action="{{route('account.show', ['type' => $activeToggle])}}" method="get">
            @include('components.filter-data-toggle')
        </form>

        {{-- Search --}}
        <div class="ml-auto">
            <input 
                type="search" 
                id="search" 
                name="search" 
                placeholder="Search..." 
                class="border border-gray-300 rounded-full px-4 py-1 focus:outline-none focus:ring-2 focus:ring-cyan-400" 
            />
        </div>
    </div>

    <table class="min-w-full text-left justify-center items-center border-b border-gray-400">
        <a href="{{ route('register') }}" 
            class="bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] hover:from-cyan-600 hover:to-blue-800 text-white font-semibold py-2 px-2 rounded-lg transition duration-300 flex items-center space-x-2 w-[130px] my-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 6v12M6 12h12" />
            </svg>
            <span>Add User</span>
        </a>
        <thead class="bg-transparent text-[#1e293b] border-b-2 border-gray-300">
            <tr class="text-center">
                <th class="py-3 px-6 font-semibold">No</th>
                <th class="py-3 px-6 font-semibold">Name</th>
                <th class="py-3 px-6 font-semibold">Position</th>
                <th class="py-3 px-6 font-semibold">Department</th>
                <th class="py-3 px-6 font-semibold">Role</th>
                <th class="py-3 px-6 font-semibold">Status</th>
                <th class="py-3 px-6 font-semibold text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $d)
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">

                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6">{{ $d->name }}</td>
                    <td class="py-4 px-6 font-semibold">{{ $d->position }}</td>
                    <td class="py-4 px-6"> {{ $d->department }} </td>
                    <td class="py-4 px-6 font-semibold">{{$d->role}}</td>
                    <td class="py-4 px-6 font-semibold text-center">
                        <span class="{{$d->status_account === 'active' ? 'bg-blue-500' : 'bg-red-500'}} text-white rounded-full px-3 py-1 text-sm font-semibold">
                            {{$d->status_account}}
                        </span>
                    </td>

                    <td class="py-4 px-6 text-center">
                        <div class="flex space-x-2 justify-center">
                            @php
                                $status = request()->query('status');
                            @endphp
                            <form action="{{route('account.edit', ['id' => $d->id])}}" method="get" class="flex justify-between space-x-2">
                                <button
                                    type="submit" name="type" value="show-dialog"
                                    class="border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                                    title="Show"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>
                            </form>

                            @if ($d->email != 'superadmin@sangnila.com')
                                @if ($d->status_account === 'active')
                                    <a href="{{route('account.edit', ['id' => $d->id, 'status' => 'suspend'])}}"
                                        class="{{$status === 'accepted' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                        title="Suspend"
                                        onclick="return confirm('are you sure suspended this account?')"
                                    >
                                        <i class="bi bi-ban"></i>
                                    </a>
                                @elseif ($d->status_account === 'suspended')
                                    <a href="{{route('account.edit', ['id' => $d->id, 'status' => 'unsuspend'])}}"
                                        class="{{$status === 'accepted' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                        title="Unsuspend"
                                        onclick="return confirm('are you sure unsuspended this account?')"
                                    >
                                        <i class="bi bi-person-check"></i>
                                    </a>
                                @endif

                                <a href="{{route('account.delete', ['id' => $d->id])}}"
                                    class="{{$status === 'rejected' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                                    title="Remove"
                                    onclick="return confirm('yakin di hapus?')"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p>No data found</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
