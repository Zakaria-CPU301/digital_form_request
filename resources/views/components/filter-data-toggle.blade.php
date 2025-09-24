<ul class="flex space-x-6 text-[#012967] font-semibold">
    @auth
        @if (auth()->user()->role === 'user')
            <li class="{{ $activeToggle === 'all' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="submit" name="type" value="all" class="hover:text-cyan-600 transition">All Data</button>
            </li>
            <li class="{{ $activeToggle === 'overwork' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="submit" name="type" value="overwork" class="hover:text-cyan-600 transition">Overwork</button>
            </li>
            <li class="{{ $activeToggle === 'leave' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="submit" name="type" value="leave" class="hover:text-cyan-600 transition">Leave</button>
            </li>
        @elseif (auth()->user()->role === 'admin')
            <li class="{{ $activeToggle === 'review' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="submit" name="status" value="review" class="hover:text-cyan-600 transition">Pending</button>
            </li>
            <li class="{{ $activeToggle === 'accepted' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="submit" name="status" value="accepted" class="hover:text-cyan-600 transition">Accepted</button>
            </li>
            <li class="{{ $activeToggle === 'rejected' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="submit" name="status" value="rejected" class="hover:text-cyan-600 transition">Rejected</button>
            </li>
        @endif
    @endauth
</ul>
