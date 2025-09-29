<x-request-layout>
  <form action="{{ isset($overwork) ? route('overwork.update', $overwork) : route('overwork.insert') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if(isset($overwork))
      @method('PUT')
    @endif

    <h2 class="text-center text-[#042E66] text-3xl font-black mb-8">Overwork Request</h2>

    <div class="flex flex-col md:flex-row justify-between max-w-5xl mx-auto">
      {{-- Submission Section --}}
        <div class="flex-1">
          <h3 class="text-[#042E66] font-extrabold text-lg mb-4">Submission Informations</h3>
          <x-submisson />

          @if (isset($evidance) && count($evidance) > 0)
            <div class="p-2 py-5">
              <div class="flex flex-wrap mb-4">
                @foreach ($evidance as $e)
                  @php
                    $ext = strtolower(pathinfo($e->path, PATHINFO_EXTENSION));
                  @endphp
                  @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $e->path) }}" alt="" width="100" class="mr-2 mb-2 rounded">
                  @endif
                @endforeach
              </div>

              <div class="flex flex-wrap">
                @foreach ($evidance as $e)
                  @php
                    $ext = strtolower(pathinfo($e->path, PATHINFO_EXTENSION));
                  @endphp
                  @if (in_array($ext, ['mp4', 'mov', 'avi']))
                    <video autoplay loop muted playsinline width="100" class="mr-2 mb-2 rounded">
                      <source src="{{ asset('storage/' . $e->path) }}" type="video/mp4">
                      Your browser does not support the video tag.
                    </video>
                  @endif
                @endforeach
              </div>
            </div>
          @endif
      </div>

      {{-- Overwork Request Section --}}
      <div class="flex-1 flex flex-col space-y-4">
        <h3 class="text-[#042E66] font-extrabold text-lg">Overwork Informations</h3>

        <div class="max-w-xs">
          <x-input-label for="date" class="font-black text-[16px] mb-1">Overwork date:</x-input-label>
          <x-text-input
            type="date"
            name="date"
            id="date"
            value="{{ old('date', isset($overwork) ? $overwork->overwork_date : '') }}"
            class="border border-gray-300 rounded px-3 py-1 w-full text-sm cursor-pointer"
            required />
        </div>

        <div class="flex items-center gap-2 max-w-xs">
          <div>
            <x-input-label for="start" class="font-black text-[16px] mb-1">Start From:</x-input-label>
            <x-text-input
              type="time"
              name="start"
              id="start"
              value="{{ old('start', isset($overwork) ? $overwork->start_overwork : '') }}"
              class="border border-gray-300 rounded px-2 py-1 text-sm w-[80px] cursor-pointer"
              required />
          </div>
          <span class="mt-7 text-gray-500">-</span>
          <div class="mt-6">
            <x-text-input
              type="time"
              name="finish"
              id="finish"
              value="{{ old('finish', isset($overwork) ? $overwork->finished_overwork : '') }}"
              class="border border-gray-300 rounded ml-3 px-2 py-1 text-sm w-[80px] cursor-pointer"
              required />
          </div>
        </div>

        <div>
          <x-input-label for="desc" class="font-black text-[16px] mb-1">Task Description:</x-input-label>
          <textarea
            name="desc"
            id="desc"
            rows="4"
            placeholder="Task you did for this overwork"
            class="border border-gray-300 rounded p-2 text-sm w-full resize-none"
            required>{{ old('desc', isset($overwork) ? $overwork->task_description : '') }}</textarea>
        </div>

        <div>
            <label>Foto (jpg/png):</label>
            <input type="file" name="photo[]" multiple value="{{ old('photo[]') }}">
            @error('photo')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Video (mp4/avi):</label>
            <input type="file" name="video[]" multiple>
            @error('video')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end space-x-4 mt-6">
          {{-- Draft Button --}}
          <button 
            type="submit" 
            name="action" 
            value="draft" 
            class="flex items-center border border-black rounded-full px-4 py-2 text-sm text-black hover:bg-gray-100 transition">
            
            <i class="bi bi-save2 mr-1 text-[#042E66]"></i>
            Draft
          </button>

          {{-- Submit Button --}}
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