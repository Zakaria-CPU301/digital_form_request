<ul class="flex space-x-6 text-[#012967] font-semibold">
    @auth
        @if (auth()->user()->role === 'user')
            <input type="hidden" name="type" class="buttonSubmit" value="{{ $type }}">
            <li class="{{ $type === 'all' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" name="type" value="all" class="status-btn hover:text-cyan-600 transition">All Data</button>
            </li>
            <li class="{{ $type === 'overwork' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" name="type" value="overwork" class="status-btn hover:text-cyan-600 transition">Overwork</button>
            </li>
            <li class="{{ $type === 'leave' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" name="type" value="leave" class="status-btn hover:text-cyan-600 transition">Leave</button>
            </li>
        @elseif (auth()->user()->role === 'admin')
            <input type="hidden" name="status" class="buttonSubmit" value="{{ $status }}">
            <li class="{{ $status === 'review' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" name="status" value="review" class="status-btn hover:text-cyan-600 transition">Review</button>
            </li>
            <li class="{{ $status === 'approved' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" name="status" value="approved" class="status-btn hover:text-cyan-600 transition">Approved</button>
            </li>
            <li class="{{ $status === 'rejected' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
                <button type="button" name="status" value="rejected" class="status-btn hover:text-cyan-600 transition">Rejected</button>
            </li>
        @endif
    @endauth
</ul>
