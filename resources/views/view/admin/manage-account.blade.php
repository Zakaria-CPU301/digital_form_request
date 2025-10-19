@extends('layouts.tables')

@section('content')

<div class="container-draft bg-[#F0F3F8] p-6 rounded-lg w-full max-w-6xl shadow-lg">
    <div id="filter" class="flex items-center mb-8">
        <h2 class="text-2xl font-bold text-[#012967]">Manage Account</h2>

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

    @php
        $activeToggle = request('status', 'pending');
    @endphp

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
                <tr class="{{ $loop->odd ? 'bg-white' : 'bg-[#f1f5f9]' }} border-b border-gray-300 capitalize">
                    
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
                        @php
                            $leavePeriod = \App\Models\Leave::where('user_id', $d->id)
                                ->where('request_status', 'approved')
                                ->sum('leave_period') / 8;
                            $leaveBalance = auth()->user()->overwork_allowance - $leavePeriod;
                            $periodDays = floor($leavePeriod);
                            $periodHours = ($leavePeriod - $periodDays) * 8;

                            if (floor($leaveBalance) == 0) {
                                $balance = ($leaveBalance - floor($leaveBalance)) * 8 . ' hours';
                            } elseif ($leaveBalance - floor($leaveBalance) == 0) {
                                $balance = floor($leaveBalance) . ' days';
                            } else {
                                $balance = floor($leaveBalance) . ' days ' . ($leaveBalance - floor($leaveBalance)) * 8 . ' hours';
                            }
                        @endphp
                        <div class="flex space-x-2 justify-center items-center">
                            <button
                                class="eye-preview-btn border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100"
                                title="Show Details"
                                data-id="{{ $d->id }}"
                                data-cration_account="{{ Carbon\Carbon::parse($d->created_at)->format('d - m - Y') }}"
                                data-name="{{ $d->name }}"
                                data-email="{{ $d->email }}"
                                data-status="{{ $d->status_account }}"
                                data-photo="{{ $d->profile_photo }}"
                                data-phone="{{ $d->phone_number }}"
                                data-position="{{ $d->position }}"
                                data-department="{{ $d->department }}"
                                data-role="{{ $d->role }}"
                                data-balance="{{ $balance }}"
                            >
                                <i class="bi bi-eye"></i>
                            </button>

                            @php
                                $status = request('status');
                            @endphp
                            @if ($d->email != 'superadmin@sangnila.com')
                                @if ($d->status_account === 'active')
                                    <a href="{{route('account.edit', ['id' => $d->id, 'status' => 'suspended'])}}"
                                        class="{{$status === 'approved' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                        title="Suspended"
                                        onclick="return confirm('are you sure want to suspend this account?')"
                                    >
                                        <i class="bi bi-ban"></i>
                                    </a>
                                @elseif ($d->status_account === 'suspended')
                                    <a href="{{route('account.edit', ['id' => $d->id, 'status' => 'unsuspended'])}}"
                                        class="{{$status === 'approved' ? 'hidden' : 'flex'}} border-2 border-gray-500 text-gray-600 rounded px-2 hover:bg-gray-100 inline-block"
                                        title="Unsuspended"
                                        onclick="return confirm('are you sure want to unsuspend this account?')"
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
            <tr class="empty">
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

<x-modal name="leave-preview-modal" maxWidth="lg">
    <div class="p-6 flex flex-col max-h-[80vh]">
        <div class="flex justify-center items-center mb-4 relative flex-shrink-0">
            <h3 class="text-xl font-extrabold text-[#012967]">
                Leave Preview
            </h3>
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'leave-preview-modal' }))"
                class="absolute right-0 text-gray-400 hover:text-gray-600 text-xl"
            >
                &times;
            </button>
        </div>
    <div id="leave-preview-account" class="space-y-3 overflow-y-auto flex-1">
            <!-- content -->
        </div>
    </div>
</x-modal>

<x-modal-success />
<script>
    document.getElementById('search').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase()
        const rows = document.querySelectorAll('tbody tr')
        rows.forEach(row => {
            if (row.cells.length > 2) {
                const dataAccount = row.cells;
                let colls = ''

                for (let i = 0; i < dataAccount.length; i++) {
                    if (i === 1) {
                        colls += dataAccount[i].textContent.toLowerCase()
                    }
                }

                if (colls.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        })
    })
    
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.eye-preview-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const date = this.dataset.cration_account;
                    const name = this.dataset.name;
                    const email = this.dataset.email;
                    const status = this.dataset.status;
                    const balance = this.dataset.balance;
                    const photo = this.dataset.photo;
                    const phone = this.dataset.phone;
                    const position = this.dataset.position;
                    const department = this.dataset.department;
                    const role = this.dataset.role;
                    const statusClass = getStatusClass(status);
                    let body = `
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Cration Date Account:</span>
                            <span class="text-gray-900 mt-2">${date}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Name:</span>
                            <span class="text-gray-900 mt-2 capitalize">${name}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Email:</span>
                            <span class="text-gray-900 mt-2">${email}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Phone Number:</span>
                            <span class="text-gray-900 mt-2">${phone}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Position:</span>
                            <span class="text-gray-900 mt-2">${position}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Position:</span>
                            <span class="text-gray-900 mt-2">${department}</span>
                        </div>
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Position:</span>
                            <span class="text-gray-900 mt-2 capitalize">${role}</span>
                        </div>
                        `;
                        body += `
                        <div class="flex flex-col items-start">
                            <span class="font-extrabold text-gray-700">Status:</span>
                            <span class="${statusClass} capitalize">${status}</span>
                        </div>
                        ${role != 'admin' 
                            ? ` <div class="flex flex-col items-start">
                                    <span class="font-extrabold text-gray-700">Leave Balance:</span>
                                    <span class="text-gray-900 mt-2">${balance}</span>
                                </div>`
                            : ''
                        }
                        `;
                    document.getElementById('leave-preview-account').innerHTML = body;
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'leave-preview-modal' }));
                });
            });
        });

        function getStatusClass(status) {
            switch(status.toLowerCase()) {
                case 'active': return 'bg-blue-500 text-white rounded-full px-3 py-1 text-sm font-semibold';
                case 'suspended': return 'bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold';
            }
        }

</script>
@endsection
