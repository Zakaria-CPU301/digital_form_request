<div x-data="{ open: false }">
    <!-- Sidebar -->
    <aside
        :class="open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 h-full w-72 bg-[#1B336B] text-white shadow-lg transform transition-transform duration-300 ease-in-out z-40 flex flex-col items-center pt-12"
    >
        <!-- User Avatar Bulat Besar -->
<div class="mb-8">
    @if(Auth::user()->profile_photo)
        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
             alt="Profile Photo" 
             class="w-[120px] h-[120px] rounded-full object-cover mx-auto">
    @else
        <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center mx-auto">
            <i class="bi bi-person text-4xl text-gray-600"></i>
        </div>
    @endif
</div>


        <!-- Greeting -->
        <h2 class="font-bold text-xl mb-10 px-3 text-center max-w-xs">
            Hi, {{ Auth::user()->name }}!
        </h2>

        <!-- Navigation Links -->
        <nav class="w-full flex flex-col">
            <!-- Contoh tiap menu dengan icon svg -->
            <a href="{{ route('dashboard') }}" 
   class="flex items-center space-x-4 px-5 py-3 
          font-semibold transition-all duration-300 
          hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10">
    <!-- Icon Home -->
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" 
         stroke-linecap="round" stroke-linejoin="round"
         viewBox="0 0 24 24">
        <path d="M3 9.75L12 3l9 6.75V21a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 21V9.75z" />
        <path d="M9 22.5V12h6v10.5" />
    </svg>
    <span>Home</span>
</a>


            <a href="{{ route('leave.form-view') }}" class="flex items-center space-x-4 px-5 py-3 hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10  font-semibold">
                <!-- Icon Apply Leave (Calendar) -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                    <path d="M16 2v4M8 2v4M3 10h18" />
                </svg>
                <span>Apply Leave</span>
            </a>

            <a href="{{ route('overwork.form-view') }}" class="flex items-center space-x-4 px-5 py-3 hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10 font-semibold">
                <!-- Icon Apply Overwork (Plus Mark) -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    viewBox="0 0 24 24">
                    <path d="M12 6v12M6 12h12" />
                </svg>
                <span>Apply Overwork</span>
            </a>

            <a href="{{ route('draft.all') }}" class="flex items-center space-x-4 px-5 py-3 hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10 font-semibold">
                <!-- Icon My Draft (File) -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                    <path d="M14 2v6h6" />
                </svg>
                <span>My Draft</span>
            </a>

            <a href="{{ route('recent.all') }}" class="flex items-center space-x-4 px-5 py-3 hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10 font-semibold">
                <!-- Icon My Application (List) -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>My Application</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-4 px-5 py-3 hover:bg-gradient-to-r hover:from-[#1EB8CD] hover:to-[#1EB8CD]/10 font-semibold">
                <!-- Icon Profile (User) -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="7" r="4" />
                    <path d="M5.5 21a6.5 6.5 0 0113 0" />
                </svg>
                <span>Profile</span>
            </a>
        </nav>
    </aside>

    <!-- Toggle Button -->
    <button
    @click="open = !open"
    :aria-expanded="open.toString()"
    aria-label="Toggle sidebar"
    class="fixed top-1/2 z-50 -translate-y-1/2 bg-[#1EB8CD] text-white w-7 h-[50px] rounded-r-full flex items-center justify-center shadow-lg transition-all duration-300"
    :style="{
        left: open ? '18rem' : '0', /* 18rem = 72px*4 = 288px sesuai width sidebar w-72 */
        transformOrigin: 'center right'
    }"
>
    <svg
        :class="open ? 'rotate-180' : ''"
        class="w-6 h-6 transition-transform duration-300"
        fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
        viewBox="0 0 24 24"
    >
        <path d="M9 18l6-6-6-6" />
    </svg>
</button>

</div>
