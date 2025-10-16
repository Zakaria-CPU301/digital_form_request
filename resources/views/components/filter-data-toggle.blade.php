<ul class="flex space-x-6 text-[#012967] font-semibold">
    @auth
        @if (auth()->user()->role === 'user')
            <li class="{{ $activeToggle === 'all' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" id="statusToggle" name="type" value="all" class="hover:text-cyan-600 transition">All Data</button>
            </li>
            <li class="{{ $activeToggle === 'overwork' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" id="statusToggle" name="type" value="overwork" class="hover:text-cyan-600 transition">Overwork</button>
            </li>
            <li class="{{ $activeToggle === 'leave' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" id="statusToggle" name="type" value="leave" class="hover:text-cyan-600 transition">Leave</button>
            </li>
        @elseif (auth()->user()->role === 'admin')
            <input type="hidden" name="status" id="statusHidden" value="{{ $activeToggle }}">
            <li class="{{ $activeToggle === 'review' ?? 'null' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" id="statusToggle" name="status" value="review" class="hover:text-cyan-600 transition">Pending</button>
            </li>
            <li class="{{ $activeToggle === 'approved' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" id="statusToggle" name="status" value="approved" class="hover:text-cyan-600 transition">Approved</button>
            </li>
            <li class="{{ $activeToggle === 'rejected' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" id="statusToggle" name="status" value="rejected" class="hover:text-cyan-600 transition">Rejected</button>
            </li>
        @endif
    @endauth
</ul>
