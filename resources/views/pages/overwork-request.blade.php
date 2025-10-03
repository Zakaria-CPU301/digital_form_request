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
                    <div class="relative group mr-2 mb-2 rounded overflow-hidden" style="width: 100px; height: 100px;">
                      <img src="{{ asset('storage/' . $e->path) }}" alt="" class="w-full h-full object-cover rounded">
                      @if(isset($overwork))
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                          <button type="button" class="text-white hover:text-gray-300 preview-evidence" data-path="{{ asset('storage/' . $e->path) }}" data-type="image" data-id="{{ $e->id }}" title="Preview">
                            <i class="bi bi-eye"></i>
                          </button>
                          <button type="button" class="text-white hover:text-gray-300 delete-evidence" data-id="{{ $e->id }}" title="Delete">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      @endif
                    </div>
                  @endif
                @endforeach
              </div>

              <div class="flex flex-wrap">
                @foreach ($evidance as $e)
                  @php
                    $ext = strtolower(pathinfo($e->path, PATHINFO_EXTENSION));
                  @endphp
                  @if (in_array($ext, ['mp4', 'mov', 'avi']))
                    <div class="relative group mr-2 mb-2 rounded overflow-hidden" style="width: 100px; height: 100px;">
                      <video autoplay loop muted playsinline class="w-full h-full object-cover rounded">
                        <source src="{{ asset('storage/' . $e->path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                      </video>
                      @if(isset($overwork))
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                          <button type="button" class="text-white hover:text-gray-300 preview-evidence" data-path="{{ asset('storage/' . $e->path) }}" data-type="video" data-id="{{ $e->id }}" title="Preview">
                            <i class="bi bi-eye"></i>
                          </button>
                          <button type="button" class="text-white hover:text-gray-300 delete-evidence" data-id="{{ $e->id }}" title="Delete">
                            <i class="bi bi-trash"></i>
                          </button>
                        </div>
                      @endif
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          @endif
      </div>

      {{-- Overwork Request Section --}}
      <div class="flex-1 flex flex-col space-y-4 w-full">
        <h3 class="text-[#042E66] font-extrabold text-lg">Overwork Informations</h3>

        <div class="w-full">
          <x-input-label for="date" class="font-black text-[16px] mb-1">Overwork date: <span class="text-red-500">*</span></x-input-label>
          <x-text-input
            type="date"
            name="date"
            id="date"
            value="{{ old('date', isset($overwork) ? $overwork->overwork_date : '') }}"
            class="border border-gray-300 rounded px-3 py-1 w-full text-sm flatpickr-date"
            required />
        </div>

        <div class="flex space-x-4 items-center w-full">
          <div class="w-full">
            <x-input-label for="start" class="font-black text-[16px] mb-1">Start: <span class="text-red-500">*</span></x-input-label>
            <x-text-input
            type="time"
            name="start"
            id="start"
            value="{{ old('start', isset($overwork) ? $overwork->start_overwork : '') }}"
            class="border border-gray-300 rounded px-2 py-1 text-sm w-full flatpickr-time"
            required />
          </div>
          <span class="mt-7 text-gray-500">
            <i class="bi bi-arrow-right text-2xl font-bold"></i>
          </span>
          <div class="w-full">
            <x-input-label for="finish" class="font-black text-[16px] mb-1">Finish: <span class="text-red-500">*</span></x-input-label>
            <x-text-input
              type="time"
              name="finish"
              id="finish"
              value="{{ old('finish', isset($overwork) ? $overwork->finished_overwork : '') }}"
              class="border border-gray-300 rounded px-2 py-1 text-sm w-full flatpickr-time"
              required/>
          </div>
        </div>

        <div>
          <x-input-label for="desc" class="font-black text-[16px] mb-1">Task Description: <span class="text-red-500">*</span></x-input-label>
          <textarea
            name="desc"
            id="desc"
            rows="4"
            placeholder="Task you did for this overwork"
            class="border border-gray-300 rounded p-2 text-sm w-full resize-none"
            required>{{ old('desc', isset($overwork) ? $overwork->task_description : '') }}</textarea>
        </div>

        <div>
            <label>Foto (jpg/png): <span class="text-red-500">*</span></label><br>
            <input type="file" name="photo[]" multiple id="photo-input" accept="image/*" value="{{ old('photo[]') }}">
            @error('photo')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label>Video (mp4/avi): <span class="text-red-500">*</span></label><br>
            <input type="file" name="video[]" multiple id="video-input" accept="video/*">
            @error('video')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Preview Container -->
        <div id="media-preview" class="mt-4" style="display: none;">
            <h4 class="font-bold text-md mb-2">Selected Files Preview:</h4>
            <div id="preview-images" class="flex flex-wrap gap-2 mb-2"></div>
            <div id="preview-videos" class="flex flex-wrap gap-2"></div>
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

<x-modal name="evidence-viewer-modal" maxWidth="6xl">
    <div class="flex items-center justify-center relative p-6">
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'evidence-viewer-modal' }))"
                class="absolute right-5 m-5 top-0 text-red-500 hover:text-red-300 text-3xl"
            >
                &times;
            </button>
        <div id="evidence-viewer-body" class="flex items-center justify-center">
            <!-- media content -->
        </div>
            <button id="prev-evidence" class="absolute left-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                &larr;
            </button>
            <button id="next-evidence" class="absolute right-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                &rarr;
            </button>
        </div>
    </div>
</x-modal>
</x-request-layout>

<script>
  function updateFinishTime(startTimeStr) {
    if (!startTimeStr) return;

    const [startHour, startMinute] = startTimeStr.split(':').map(Number);

    const startDate = new Date();
    startDate.setHours(startHour, startMinute, 0);

    const finishDate = new Date(startDate);
    finishDate.setHours(finishDate.getHours() + 2);

    const finishHourStr = String(finishDate.getHours()).padStart(2, '0');
    const finishMinuteStr = String(finishDate.getMinutes()).padStart(2, '0');
    const finishTimeStr = `${finishHourStr}:${finishMinuteStr}`;

    const finishInput = document.getElementById('finish');
    finishInput.value = finishTimeStr;
    finishInput.min = finishTimeStr;
    finishInput.disabled = false;
  }

  document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.getElementById('start');
    
    if (startInput.value) {
      updateFinishTime(startInput.value);
    }

    startInput.addEventListener('change', function () {
      updateFinishTime(this.value);
    });
  });

  let currentEvidences = [];
  let currentIndex = 0;

  function collectEvidences() {
    currentEvidences = [];
    document.querySelectorAll('.preview-evidence').forEach((btn, index) => {
      currentEvidences.push({
        path: btn.dataset.path,
        type: btn.dataset.type,
        id: btn.dataset.id
      });
    });
  }

  function showEvidence(index) {
    const e = currentEvidences[index];
    let mediaHtml = '';
    if (e.type === 'image') {
      mediaHtml = `<img src="${e.path}" alt="Evidence" class="max-w-full max-h-[80vh] rounded shadow-lg">`;
    } else if (e.type === 'video') {
      mediaHtml = `<video src="${e.path}" class="max-w-full max-h-[80vh] rounded shadow-lg" controls autoplay></video>`;
    }
    document.getElementById('evidence-viewer-body').innerHTML = mediaHtml;
    document.getElementById('prev-evidence').style.display = index > 0 ? 'block' : 'none';
    document.getElementById('next-evidence').style.display = index < currentEvidences.length - 1 ? 'block' : 'none';
  }

  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('preview-evidence') || e.target.closest('.preview-evidence')) {
      e.preventDefault();
      collectEvidences();
      const btn = e.target.classList.contains('preview-evidence') ? e.target : e.target.closest('.preview-evidence');
      const path = btn.dataset.path;
      currentIndex = currentEvidences.findIndex(ev => ev.path === path);
      showEvidence(currentIndex);
      window.dispatchEvent(new CustomEvent('open-modal', { detail: 'evidence-viewer-modal' }));
    }
  });

  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-evidence') || e.target.closest('.delete-evidence')) {
      e.preventDefault();
      const btn = e.target.classList.contains('delete-evidence') ? e.target : e.target.closest('.delete-evidence');
      const id = btn.dataset.id;
      if (confirm('Are you sure you want to delete this evidence?')) {
        fetch(`/overwork/evidance/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            btn.closest('.relative').remove();
          } else {
            alert('Failed to delete evidence: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while deleting the evidence.');
        });
      }
    }
  });

  document.getElementById('prev-evidence').addEventListener('click', function() {
    if (currentIndex > 0) {
      currentIndex--;
      showEvidence(currentIndex);
    }
  });

  document.getElementById('next-evidence').addEventListener('click', function() {
    if (currentIndex < currentEvidences.length - 1) {
      currentIndex++;
      showEvidence(currentIndex);
    }
  });

  // Media Preview Functionality
  let selectedPhotos = [];
  let selectedVideos = [];

  function updatePreviewVisibility() {
    const previewContainer = document.getElementById('media-preview');
    if (selectedPhotos.length > 0 || selectedVideos.length > 0) {
      previewContainer.style.display = 'block';
    } else {
      previewContainer.style.display = 'none';
    }
  }

  function createImagePreview(file, index) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const previewDiv = document.createElement('div');
      previewDiv.className = 'relative group';
      previewDiv.innerHTML = `
        <div class="h-[150px] rounded overflow-hidden border-2 border-gray-300">
          <img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">
        </div>
        <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 remove-file" data-type="photo" data-index="${index}" title="Remove">
          ×
        </button>
      `;
      document.getElementById('preview-images').appendChild(previewDiv);
    };
    reader.readAsDataURL(file);
  }

  function createVideoPreview(file, index) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const previewDiv = document.createElement('div');
      previewDiv.className = 'relative group';
      previewDiv.innerHTML = `
        <div class="h-[150px] rounded overflow-hidden border-2 border-gray-300 bg-gray-100 flex items-center justify-center">
          <video class="w-full h-full object-cover" muted controls autoplay loop playsinline>
            <source src="${e.target.result}" type="${file.type}">
          </video>
        </div>
        <button type="button" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 remove-file" data-type="video" data-index="${index}" title="Remove">
          ×
        </button>
      `;
      document.getElementById('preview-videos').appendChild(previewDiv);
    };
    reader.readAsDataURL(file);
  }

  function updateFileInputs() {
    // Update photo input
    const photoInput = document.getElementById('photo-input');
    const photoDataTransfer = new DataTransfer();
    selectedPhotos.forEach(file => {
      photoDataTransfer.items.add(file);
    });
    photoInput.files = photoDataTransfer.files;

    // Update video input
    const videoInput = document.getElementById('video-input');
    const videoDataTransfer = new DataTransfer();
    selectedVideos.forEach(file => {
      videoDataTransfer.items.add(file);
    });
    videoInput.files = videoDataTransfer.files;
  }

  // Photo input change handler
  document.getElementById('photo-input').addEventListener('change', function(e) {
    const newPhotos = Array.from(e.target.files);
    // Add new photos to existing selection
    selectedPhotos = selectedPhotos.concat(newPhotos);
    // Clear and recreate all previews
    document.getElementById('preview-images').innerHTML = '';
    selectedPhotos.forEach((file, index) => {
      createImagePreview(file, index);
    });
    updatePreviewVisibility();
    // Clear the input so user can select the same files again if needed
    this.value = '';
  });

  // Video input change handler
  document.getElementById('video-input').addEventListener('change', function(e) {
    const newVideos = Array.from(e.target.files);
    // Add new videos to existing selection
    selectedVideos = selectedVideos.concat(newVideos);
    // Clear and recreate all previews
    document.getElementById('preview-videos').innerHTML = '';
    selectedVideos.forEach((file, index) => {
      createVideoPreview(file, index);
    });
    updatePreviewVisibility();
    // Clear the input so user can select the same files again if needed
    this.value = '';
  });

  // Remove file handler
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-file')) {
      const type = e.target.dataset.type;
      const index = parseInt(e.target.dataset.index);

      if (type === 'photo') {
        selectedPhotos.splice(index, 1);
        document.getElementById('preview-images').innerHTML = '';
        selectedPhotos.forEach((file, idx) => {
          createImagePreview(file, idx);
        });
      } else if (type === 'video') {
        selectedVideos.splice(index, 1);
        document.getElementById('preview-videos').innerHTML = '';
        selectedVideos.forEach((file, idx) => {
          createVideoPreview(file, idx);
        });
      }

      updateFileInputs();
      updatePreviewVisibility();
    }
  });

</script>
