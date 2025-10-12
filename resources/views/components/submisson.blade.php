@props(['allowance', 'leave_period'])
<div class="flex flex-col gap-2 w-[450px]">
    <x-text-input class="font-medium shadow-none" type="hidden" name="user_id" id="" value="{{auth()->user()->id}}" />
    <x-input-label for="name" class="font-bold text-md">Name:</x-input-label>
    <h1 class="mb-1 border-2 py-2 px-3 rounded-md">{{auth()->user()->name}}</h1>
    <x-input-label for="position" class="font-bold text-md">Position:</x-input-label>
    <h1 class="mb-1 border-2 py-2 px-3 rounded-md">{{auth()->user()->position}}</h1>
    <x-input-label for="department" class="font-bold text-md">Department:</x-input-label>
    <h1 class="mb-1 border-2 py-2 px-3 rounded-md">{{auth()->user()->department}}</h1>
    @if (request()->segment(1) === 'leave')
        @php
            $leaveBalance = $allowance - $leave_period;
            $balance = floor($leaveBalance) . ' days ' . ($leaveBalance - floor($leaveBalance)) * 8 . ' hours';
        @endphp
        <x-input-label for="department" class="font-bold text-md">Leave Balance:</x-input-label>
        <h1 class="mb-1 border-2 py-2 px-3 rounded-md">{{$balance}}</h1>
    @endif
</div>