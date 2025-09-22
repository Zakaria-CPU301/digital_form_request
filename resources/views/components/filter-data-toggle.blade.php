<ul class="flex space-x-6 text-[#012967] font-semibold">
    <li class="{{ $activeToggle === 'all' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
        <button type="submit" name="type" value="all" class="hover:text-cyan-600 transition">All Data</button>
    </li>
    <li class="{{ $activeToggle === 'overwork' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
        <button type="submit" name="type" value="overwork" class="hover:text-cyan-600 transition">Overwork</button>
    </li>
    <li class="{{ $activeToggle === 'leave' ? 'border-b-4 border-cyan-400 pb-1' : '' }} cursor-pointer">
        <button type="submit" name="type" value="leave" class="hover:text-cyan-600 transition">Leave</button>
    </li>
</ul>
