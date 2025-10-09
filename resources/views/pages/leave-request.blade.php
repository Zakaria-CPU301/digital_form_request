<x-request-layout>
  <form action="{{ isset($leave) ? route('leave.update', $leave) : route('leave.insert') }}" method="post" enctype="multipart/form-data">
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
        <h3 class="text-[#042E66] font-extrabold text-lg">Leave Informations</h3>
        <div class="flex flex-col w-full">
          <div class="rangeTime flex flex-col w-full mb-1">
            <x-input-label for="leave_type" class="font-bold text-md mb-2">Start: <span class="text-red-500">*</span></x-input-label>
            <input
              type="date"
              name="start"
              id="start"
              value="{{ old('start', isset($leave) ? $leave->start_leave : '') }}"
              class="mb-2 border-2 py-2 px-3 rounded-md border-gray-300"
              required
              />
            </div>
        <div class="flex flex-col">
          <div class="rangeTime flex w-full">
            <x-input-label for="leave_type" class="font-bold text-md mb-2">How Many Days? <span class=" text-red-500">*</span></x-input-label>
            </div>
           <div class="flex flex-row h-10">
            <input
              type="number"
              name="finish"
              id="finish"
              value="{{ old('finish', isset($leave) ? $leave->finished_leave : '0') }}"
              class="mb-2 border-2 py-5 px-3 rounded-md border-gray-300 w-full"
              required
              /> 
            <span class=" text-gray-500 mt-2 ml-2">
                Day(s)
              </span> 
           </div>
         </div>
        <div>
        <div class="flex flex-col mt-3">
          <div class="rangeTime flex w-full">
            <x-input-label for="leave_type" class="mb-2">How Many Hours? <span class=" text-red-500">*</span></x-input-label>
            </div>
           <div class="flex flex-row h-10">
            <x-text-input
              type="number"
              name="finish"
              id="finish"
              value="{{ old('finish', isset($leave) ? $leave->finished_leave : '0') }}"
              class="mb-2 border-2 py-5 px-3 rounded-md border-gray-300 w-full"
              required
              /> 
            <span class=" text-gray-500 mt-2 ml-2">
                Hour(s)
              </span> 
           </div>
         </div>
        <div>
          <x-input-label for="reason" class="mt-4">Leave Reason: <span class="text-red-500">*</span></x-input-label>
          <textarea
            name="reason"
            id="reason"
            rows="4"
            placeholder="Write your leave reason here..."
            class="border border-gray-300 rounded p-2 text-sm w-full resize-none"
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

<script>
  const showPicker = ['start', 'finish']
  showPicker.forEach((e, i) => {
    document.getElementById(e).addEventListener('click', () => {
        document.getElementById(showPicker[i]).showPicker()
    })
  });  
document.addEventListener("DOMContentLoaded", () => {
    const startInput = document.getElementById('start');
    const finishInput = document.getElementById('finish');
    const arrowAnimate = document.querySelectorAll(".rangeTime input");

    const todayFormatted = new Date().toLocaleDateString('en-CA');
    startInput.setAttribute('min', todayFormatted);

    function updateFinishDate(startDateStr) {
        if (!startDateStr) return;

        const startDate = new Date(startDateStr);
        const finishDate = new Date(startDate);
        finishDate.setDate(finishDate.getDate() + 1);

        const finishFormatted = finishDate.toISOString().split('T')[0];

        finishInput.value = finishFormatted;
        finishInput.removeAttribute('disabled');
        finishInput.setAttribute('min', finishFormatted);

        arrowAnimate.forEach(arrow => {
            arrow.style.opacity = "1";
            arrow.style.zIndex = "100";
        });
    }

    // Jalankan saat load, jika start sudah terisi
    if (startInput.value) {
        updateFinishDate(startInput.value);
    }

    // Jalankan saat user mengubah input start
    startInput.addEventListener('change', function () {
        updateFinishDate(this.value);
    });
});

</script>