<x-request-layout>
  <form action="{{ route('overwork.insert') }}" method="post">
    @csrf

      <h2 class="text-center text-[#042E66] text-xl font-extrabold mb-8">Overwork Request</h2>

      <div class="flex flex-col md:flex-row gap-8 max-w-3xl mx-auto">
        {{-- Submission Section --}}
        <div class="flex-1">
          <h3 class="text-[#042E66] font-semibold mb-4">Submission Informations</h3>
          <x-submisson />
        </div>

        {{-- Overwork Request Section --}}
        <div class="flex-1 flex flex-col space-y-4">
          <h3 class="text-[#042E66] font-semibold mb-4">Overwork Informations</h3>

          <div class="max-w-xs">
            <x-input-label for="date" class="font-bold text-sm mb-1">Tanggal Lembur</x-input-label>
            <x-text-input 
              type="date" 
              name="date" 
              id="date" 
              class="border border-gray-300 rounded px-3 py-1 w-full text-sm cursor-pointer" 
              required />
          </div>

          <div class="flex items-center gap-2 max-w-xs">
            <div>
              <x-input-label for="start" class="font-bold text-sm mb-1">Mulai Lembur</x-input-label>
              <x-text-input 
                type="time" 
                name="start" 
                id="start" 
                class="border border-gray-300 rounded px-2 py-1 text-sm w-[70px] cursor-pointer" 
                required />
            </div>
            <span class="mt-7 text-gray-500">-</span>
            <div class="mt-6">
              <x-text-input 
                type="time" 
                name="finish" 
                id="finish" 
                class="border border-gray-300 rounded px-2 py-1 text-sm w-[70px] cursor-pointer" 
                required />
            </div>
          </div>

          <div>
            <x-input-label for="desc" class="font-bold text-sm mb-1">Deskripsi</x-input-label>
            <textarea 
              name="desc" 
              id="desc" 
              rows="4" 
              placeholder="Create Login Page Design:&#10;Design a responsive login page in Figma following the company’s branding guidelines. Include both light and dark mode variations."
              class="border border-gray-300 rounded p-2 text-xs w-full resize-none"
              required></textarea>
          </div>

          <div class="flex justify-end space-x-4 mt-6">
            <button 
              type="submit" 
              name="action" 
              value="draft" 
              class="flex items-center border border-black rounded-full px-4 py-2 text-sm text-black hover:bg-gray-100 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13v6a2 2 0 002 2h8a2 2 0 002-2v-6M9 10l3 3 3-3M12 12v-3" />
              </svg>
              Draft
            </button>

            <button 
              type="submit" 
              name="action" 
              value="submit" 
              class="flex items-center bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-full px-4 py-2 text-sm transition hover:from-cyan-600 hover:to-blue-700">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10M14 5l7 7-7 7" />
              </svg>
              Submit
            </button>
          </div>
        </div>
      </div>
  </form>
</x-request-layout>