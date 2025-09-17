<x-request-layout>
  <form action="{{ isset($leave) ? route('leave.update', $leave) : route('leave.insert') }}" method="post">
    @csrf
    @if(isset($leave))
      @method('PUT')
    @endif

    <h2 class="text-center text-[#042E66] text-3xl font-extrabold mb-8">Leave Request</h2>

    <div class="flex flex-col md:flex-row justify-between max-w-5xl mx-auto">
      {{-- Submission Section --}}
      <div class="flex-1">
        <h3 class="text-[#042E66] font-extrabold text-lg mb-4">Submission Informations</h3>
        <x-submisson />
      </div>

      {{-- Leave Request Section --}}
      <div class="flex-1 flex flex-col space-y-4">
        <h3 class="text-black font-extrabold text-lg mb-4">Leave Informations</h3>

        <div class="max-w-xs">
          <x-input-label for="start" class="font-bold text-sm mb-1">Mulai Cuti</x-input-label>
          <x-text-input
            type="date"
            name="start"
            id="start"
            value="{{ old('start', isset($leave) ? $leave->start_leave : '') }}"
            class="border border-gray-300 rounded px-3 py-1 w-full text-sm cursor-pointer"
            required />
        </div>

        <div class="max-w-xs">
          <x-input-label for="finish" class="font-bold text-sm mb-1">Selesai Cuti</x-input-label>
          <x-text-input
            type="date"
            name="finish"
            id="finish"
            value="{{ old('finish', isset($leave) ? $leave->finished_leave : '') }}"
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
            required>{{ old('reason', isset($leave) ? $leave->reason : '') }}</textarea>
        </div>

        <div class="flex justify-end space-x-4 mt-6">
          {{-- Draft --}}
          <button 
            type="submit" 
            name="action" 
            value="draft" 
            class="flex items-center border border-black rounded-full px-4 py-2 text-sm text-black hover:bg-gray-100 transition">
            
            <i class="bi bi-save mr-1"></i>
            Draft
          </button>

          {{-- Submit --}}
          <button 
            type="submit" 
            name="action" 
            value="submit" 
            class="flex items-center bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] text-white rounded-full px-4 py-2 text-sm transition hover:from-cyan-600 hover:to-blue-700">
            
            <i class="bi bi-send-fill mr-1"></i>
            Submit
          </button>
                    </div>
      </div>
    </div>
  </form>
</x-request-layout>
