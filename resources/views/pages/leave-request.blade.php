<x-request-layout>
<form action="{{route('leave.insert')}}" method="post" class="">
    @csrf
    <div class="flex">
        {{-- submission --}}
        <x-submisson />
        
        {{-- leave_request --}}
        <div class="flex flex-col">
            <x-input-label>Mulai Cuti</x-input-label>
            <x-text-input type="date" name="start" id="" />
            <x-input-label>Selesai Cuti</x-input-label>
            <x-text-input type="date" name="finish" id="" />
            <x-input-label>Alasan Cuti</x-input-label>
            <textarea name="reason" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
            <div class="action flex justify-evenly">
                <button type="submit" name="action" value="draft">draft</button>
                <button type="submit" name="action" value="submit">submit</button>
            </div>
        </div>
    </div>
</form>
</x-request-layout>