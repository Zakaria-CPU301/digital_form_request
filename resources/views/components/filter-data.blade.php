<div class="action flex justify-between items-center">
    <ul class="flex gap-5">
        <li><a href="{{route('draft.all')}}" class="py-2 px-5 bg-blue-100 rounded-lg">All</a></li>
        <li><a href="{{route('draft.overwork')}}" class="py-2 px-5 bg-blue-100 rounded-lg">Overwork</a></li>
        <li><a href="{{route('draft.leave')}}" class="py-2 px-5 bg-blue-100 rounded-lg">Leave</a></li>
    </ul>

    <x-text-input type="text" name="search" id="search" placeholder="Search Data" />
</div>
