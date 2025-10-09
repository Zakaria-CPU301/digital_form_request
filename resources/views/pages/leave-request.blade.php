<x-request-layout>
  <form action="{{ isset($leave) ? route('leave.update', $leave) : route('leave.insert') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if(isset($leave))
      @method('PUT')
    @endif
{{-- 
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

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
          <div class="rangeTime flex flex-col w-full">
            <x-input-label for="startDate" class="font-bold text-md mb-1">Start Date: <span class="text-red-500">*</span></x-input-label>
            <x-text-input
              type="date"
              name="start_leave"
              id="startDate"
              value="{{ old('start_leave', isset($leave) ? $leave->start_leave : '') }}"
              class="border border-gray-400 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1EB8CD] cursor-pointer"
              />
            <x-unvalid-input field="start_leave" />
          </div>
        <div class="flex flex-col mt-3">
          <div class="rangeTime flex w-full">
            <x-input-label for="manyDays" class="font-bold text-md mb-1">How Many Days? <span class=" text-red-500">*</span></x-input-label>
            </div>
           <div class="flex flex-row h-10">
            <x-text-input
              type="number"
              step="0.5"
              min="0"
              oninput="if(this.value < 0) this.value = 0;"
              onblur="if(this.value === '') this.value = 0;"
              name="many_days"
              id="manyDays"
              value="{{ old('many_days', isset($leave) ? $leave->finished_leave : '0') }}"
              class="border border-gray-400 rounded-lg px-3 py-2 text-lg focus:outline-none focus:ring-2 focus:ring-[#1EB8CD] cursor-pointer w-20"
              /> 
              <span class=" text-gray-500 mt-2 ml-2">
                Day(s)
              </span> 
            </div>
            <x-unvalid-input field="many_days" />
          </div>
        <div>
        <div class="flex flex-col mt-3">
          <div class="rangeTime flex w-full">
            <x-input-label for="manyHour" class="font-bold text-md mb-1">How Many Hours? <span class=" text-red-500">*</span></x-input-label>
          </div>
            <div class="flex flex-row h-10">
            <x-text-input
              type="number"
              min="0"
              max="7"
              oninput="if(this.value < 0) this.value = 0;"
              onblur="if(this.value === '') this.value = 0;"
              name="many_hours"
              id="manyHours"
              value="{{ old('many_hours', isset($leave) ? $leave->finished_leave : '0') }}"
              class="border border-gray-400 rounded-lg px-3 py-2 text-lg focus:outline-none focus:ring-2 focus:ring-[#1EB8CD] cursor-pointer w-20"
              /> 
            <span class=" text-gray-500 mt-2 ml-2">
                Hour(s)
              </span> 
            </div>
            <x-unvalid-input field="many_hours" />
         </div>
        <div>
          <x-input-label for="reason" class="font-bold text-md mb-1">Leave Reason: <span class="text-red-500">*</span></x-input-label>
          <textarea
            name="reason"
            id="reason"
            rows="4"
            placeholder="Write your leave reason here..."
            class="border border-gray-300 rounded p-2 text-sm w-full resize-none"
            >{{ old('reason', isset($leave) ? $leave->reason : '') }}</textarea>
            <x-unvalid-input field="reason" />
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
  
    document.addEventListener('DOMContentLoaded', () => {
      const manyDays = document.getElementById('manyDays');
      const manyHours = document.getElementById('manyHours');

      manyDays.addEventListener('input', () => {
        const value = parseFloat(manyDays.value) || 0;
        const decimalPart = value - Math.floor(value); 

        if (decimalPart > 0) {
          const remainingHours = 8 - (decimalPart * 8); 
          manyHours.max = remainingHours - 2; 
        } else {
          manyHours.max = 7; 
        }

        if (parseFloat(manyHours.value) > parseFloat(manyHours.max)) {
          manyHours.value = manyHours.max;
        }
      });
    });
  
  document.getElementById('startDate').addEventListener('click', () => {
    console.log('click');
    
      document.getElementById('startDate').showPicker()
  })
</script>