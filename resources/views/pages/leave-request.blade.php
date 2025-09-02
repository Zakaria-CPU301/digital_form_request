<x-request-layout>
  <form action="{{ route('leave.insert') }}" method="post">
    @csrf

    <h2 class="text-center text-[#042E66] text-xl font-extrabold mb-8">Leave Request</h2>

    <div class="flex flex-col md:flex-row gap-8 max-w-3xl mx-auto">
      {{-- Submission Section --}}
      <div class="flex-1">
        <h3 class="text-[#042E66] font-semibold mb-4">Submission Informations</h3>
        <x-submisson />
      </div>

      {{-- Leave Request Section --}}
      <div class="flex-1 flex flex-col space-y-4">
        <h3 class="text-[#042E66] font-semibold mb-4">Leave Informations</h3>

        <div class="max-w-xs">
          <x-input-label for="start" class="font-bold text-sm mb-1">Mulai Cuti</x-input-label>
          <x-text-input 
            type="date" 
            name="start" 
            id="start" 
            class="border border-gray-300 rounded px-3 py-1 w-full text-sm cursor-pointer" 
            required />
        </div>

        <div class="max-w-xs">
          <x-input-label for="finish" class="font-bold text-sm mb-1">Selesai Cuti</x-input-label>
          <x-text-input 
            type="date" 
            name="finish" 
            id="finish" 
            class="border border-gray-300 rounded px-3 py-1 w-full text-sm cursor-pointer" 
            required />
        </div>

        <div>
          <x-input-label for="reason" class="font-bold text-sm mb-1">Alasan Cuti</x-input-label>
          <textarea 
            name="reason" 
            id="reason" 
            rows="4" 
            placeholder="Tuliskan alasan cuti Anda di sini..."
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