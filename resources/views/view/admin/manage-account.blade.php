@extends('layouts.tables')

@section('content')
<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <!-- Title -->
    <h2 class="text-2xl font-bold text-[#012967] mb-4">Manage Account</h2>

    <!-- Filter + Search -->
    <div id="filter" class="flex items-center mb-6">
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

    <!-- Draft Table -->
    <table class="min-w-full text-left justify-center border-b border-gray-400">
        <thead class="bg-transparent text-[#1e293b] border-b-2 border-gray-300">
            <tr>
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
            @foreach($data as $d)
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300">
                    
                    <!-- Number -->
                    <td class="py-4 px-6">{{ $loop->iteration }}</td>

                    <!-- Date -->
                    <td class="py-4 px-6">{{ $d->name }}</td>
                    
                    <!-- Type -->
                    <td class="py-4 px-6 font-semibold">{{ $d->position }}</td>
                    
                    <!-- Status -->
                    <td class="py-4 px-6"> {{ $d->department }} </td>
                    
                    <!-- Status -->
                    <td class="py-4 px-6 font-semibold">{{$d->role}}</td>

                    <!-- Status -->
                    <td class="py-4 px-6 font-semibold">{{$d->status_account}}</td>
                    
                    <!-- Action -->
                    <td class="py-4 px-6 text-center space-x-2 flex">
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

                        <a href="{{route('account.edit', ['id' => $d->id])}}"
                            type="submit" name="status" value="ban"
                            class="{{$status === 'accepted' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block" 
                            title="Accepted"
                            onclick="return confirm('yakin di ban?')"
                        >
                            <i class="bi bi-ban"></i>
                        </a>

                        <a href="{{route('account.delete', ['id' => $d->id])}}"
                            class="{{$status === 'rejected' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100" 
                            title="Rejected"
                            onclick="return confirm('yakin di hapus?')"
                        >
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
