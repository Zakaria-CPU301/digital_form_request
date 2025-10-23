<x-request-layout>
    <form
        action="{{ isset($overwork) ? route('overwork.update', $overwork) : route('overwork.insert') }}"
        method="post"
        enctype="multipart/form-data"
    >
        @csrf
        @if(isset($overwork))
            @method('PUT')
        @endif

        <h2 class="text-center text-[#042E66] text-3xl font-black mb-8">
            Overwork Request
        </h2>

        <div class="flex flex-col md:flex-row justify-between max-w-5xl mx-auto">
            
            {{-- ================= Submission Section ================= --}}
            <div class="flex-1">
                <h3 class="text-[#042E66] font-extrabold text-lg mb-4">
                    Submission Informations
                </h3>

                <x-submisson />

                {{-- Evidence Preview --}}
                @if (isset($evidence) && count($evidence) > 0)
                    <div class="p-2 py-5">
                        {{-- Images --}}
                        <div class="flex flex-wrap mb-4">
                            @foreach ($evidence as $e)
                                @php
                                    $ext = strtolower(pathinfo($e->path, PATHINFO_EXTENSION));
                                @endphp

                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                    <div class="relative group mr-2 mb-2 rounded overflow-hidden" style="width: 100px; height: 100px">
                                        <img src="{{ asset('storage/' . $e->path) }}" alt="" class="w-full h-full object-cover rounded" />

                                        @if(isset($overwork))
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button
                                                    type="button"
                                                    class="text-white hover:text-gray-300 preview-evidence"
                                                    data-path="{{ asset('storage/' . $e->path) }}"
                                                    data-type="image"
                                                    data-id="{{ $e->id }}"
                                                    title="Preview"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="text-white hover:text-gray-300 delete-evidence"
                                                    data-id="{{ $e->id }}"
                                                    title="Delete"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Videos --}}
                        <div class="flex flex-wrap">
                            @foreach ($evidence as $e)
                                @php
                                    $ext = strtolower(pathinfo($e->path, PATHINFO_EXTENSION));
                                @endphp

                                @if (in_array($ext, ['mp4', 'mov', 'avi']))
                                    <div class="relative group mr-2 mb-2 rounded overflow-hidden" style="width: 100px; height: 100px">
                                        <video autoplay loop muted playsinline class="w-full h-full object-cover rounded">
                                            <source src="{{ asset('storage/' . $e->path) }}" type="video/mp4" />
                                        </video>

                                        @if(isset($overwork))
                                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button
                                                    type="button"
                                                    class="text-white hover:text-gray-300 preview-evidence"
                                                    data-path="{{ asset('storage/' . $e->path) }}"
                                                    data-type="video"
                                                    data-id="{{ $e->id }}"
                                                    title="Preview"
                                                >
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="text-white hover:text-gray-300 delete-evidence"
                                                    data-id="{{ $e->id }}"
                                                    title="Delete"
                                                >
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

            {{-- ================= Overwork Section ================= --}}
            <div class="flex-1 flex flex-col w-full">
                <h3 class="text-[#042E66] font-extrabold text-lg">Overwork Informations</h3>

                {{-- Date Input --}}
                <div class="w-full relative mt-4">
                    <x-input-label for="date" class="font-black text-[16px] mb-2">
                        Overwork date: <span class="text-red-500">*</span>
                    </x-input-label>
                    <x-text-input
                        type="date"
                        name="date"
                        id="date"
                        value="{{ old('date', isset($overwork) ? $overwork->overwork_date : '') }}"
                        class="border-2 h-[45px] px-3 rounded-md border-gray-300 w-full"
                        />
                        <x-unvalid-input field="date" />
                </div>

                {{-- Start & Finish Time --}}
                <div class="flex mt-3 items-center w-full gap-4">
                    <div class="w-full relative">
                        <x-input-label for="start" class="font-black text-[16px] mb-1">
                            Start: <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input
                            type="time"
                            name="start"
                            id="start"
                            value="{{ old('start', isset($overwork) ? $overwork->start_overwork : '17:00') }}"
                            class="border-2 w-full"
                            />
                            <x-unvalid-input field="start" />
                    </div>

                    <i class="bi bi-arrow-right text-2xl text-gray-500"></i>

                    <div class="w-full relative">
                        <x-input-label for="finish" class="font-black text-[16px] mb-1">
                            Finish: <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input
                            type="time"
                            name="finish"
                            id="finish"
                            value="{{ old('finish', isset($overwork) ? $overwork->finished_overwork : '') }}"
                            class="border-2 w-full"
                            required
                        />
                        <x-unvalid-input field="finish" />
                    </div>
                </div>

                {{-- Description --}}
                <div class="mt-4">
                    <x-input-label for="desc" class="font-black text-[16px] mb-1">
                        Task Description: <span class="text-red-500">*</span>
                    </x-input-label>
                    <textarea
                        name="desc"
                        id="desc"
                        rows="4"
                        placeholder="Task you did for this overwork"
                        class="border-2 border-gray-300 rounded px-3 text-md w-full resize-none"
                        required
                    >{{ old('desc', isset($overwork) ? $overwork->task_description : '') }}</textarea>
                </div>

                {{-- Upload Inputs --}}
                <div class="mt-4 space-y-4">
                    <label class="text-gray-500">Please upload a photo or video evidence <span class="text-red-500">*</span></label><br />
                    <div class="pl-2">
                        <label>Photo:</label><br />
                        <input type="file" name="photo[]" multiple id="photo-input" accept="image/*" />
                        @error('photo')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pl-2">
                        <label>Video:</label><br />
                        <input type="file" name="video[]" multiple id="video-input" accept="video/*" />
                        @error('video')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Media Preview --}}
                <div id="media-preview" class="mt-4 hidden">
                    <h4 class="font-bold text-md mb-2">Selected Files Preview:</h4>
                    <div id="preview-images" class="flex flex-wrap gap-2 mb-2"></div>
                    <div id="preview-videos" class="flex flex-wrap gap-2"></div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end space-x-4 mt-6">
                    <button
                        type="submit"
                        name="action"
                        value="draft"
                        class="flex items-center border border-black rounded-full px-4 py-2 text-sm text-black hover:bg-gray-100 transition"
                    >
                        <i class="bi bi-save2 mr-1 text-[#042E66]"></i>
                        Draft
                    </button>

                    <button
                        type="submit"
                        name="action"
                        value="submit"
                        class="flex items-center bg-gradient-to-r from-[#1EB8CD] to-[#2652B8] text-white rounded-full px-4 py-2 text-sm transition hover:from-cyan-600 hover:to-blue-700"
                    >
                        <i class="bi bi-send-fill mr-1"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- ================= Evidence Viewer Modal ================= --}}
    <x-modal name="evidence-viewer-modal" maxWidth="6xl">
        <div class="flex items-center justify-center relative p-6">
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'evidence-viewer-modal' }))"
                class="absolute right-5 top-0 m-5 text-red-500 hover:text-red-300 text-3xl"
            >
                &times;
            </button>

            <div id="evidence-viewer-body" class="flex items-center justify-center"></div>

            <button id="prev-evidence" class="absolute left-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">&larr;</button>
            <button id="next-evidence" class="absolute right-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">&rarr;</button>
        </div>
    </x-modal>
</x-request-layout>

{{-- ================= JS Section ================= --}}
<script>
    // showPicker for custom trigger
    ['date'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('click', () => el.showPicker());
    });

    // Auto-update finish time +2h
    function updateFinishTime(startTimeStr) {
        if (!startTimeStr) return;
        const [h, m] = startTimeStr.split(':').map(Number);
        const finish = new Date();
        finish.setHours(h + 2, m, 0);
        const timeStr = `${String(finish.getHours()).padStart(2, '0')}:${String(finish.getMinutes()).padStart(2, '0')}`;
        const finishInput = document.getElementById('finish');
        finishInput.value = timeStr;
        finishInput.min = timeStr;
        finishInput.disabled = false;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const start = document.getElementById('start');
        if (start?.value) updateFinishTime(start.value);
        start?.addEventListener('change', e => updateFinishTime(e.target.value));
    });

    // === Evidence Viewer Logic ===
    let evidences = [], currentIndex = 0;

    function collectEvidences() {
        evidences = [...document.querySelectorAll('.preview-evidence')].map(btn => ({
            path: btn.dataset.path,
            type: btn.dataset.type,
            id: btn.dataset.id,
        }));
    }

    function showEvidence(index) {
        const e = evidences[index];
        const body = document.getElementById('evidence-viewer-body');
        body.innerHTML = e.type === 'image'
            ? `<img src="${e.path}" class="max-w-full max-h-[80vh] rounded shadow-lg" />`
            : `<video src="${e.path}" controls autoplay class="max-w-full max-h-[80vh] rounded shadow-lg"></video>`;
        document.getElementById('prev-evidence').style.display = index > 0 ? 'block' : 'none';
        document.getElementById('next-evidence').style.display = index < evidences.length - 1 ? 'block' : 'none';
    }

    document.addEventListener('click', e => {
        const preview = e.target.closest('.preview-evidence');
        const del = e.target.closest('.delete-evidence');

        if (preview) {
            e.preventDefault();
            collectEvidences();
            currentIndex = evidences.findIndex(ev => ev.path === preview.dataset.path);
            showEvidence(currentIndex);
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'evidence-viewer-modal' }));
        }

        if (del && confirm('Are you sure you want to delete this evidence?')) {
            const id = del.dataset.id;
            fetch(`/overwork/evidence/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) del.closest('.relative').remove();
                else alert('Failed to delete: ' + data.message);
            })
            .catch(() => alert('An error occurred while deleting.'));
        }
    });

    document.getElementById('prev-evidence')?.addEventListener('click', () => currentIndex > 0 && showEvidence(--currentIndex));
    document.getElementById('next-evidence')?.addEventListener('click', () => currentIndex < evidences.length - 1 && showEvidence(++currentIndex));

    // === Media Preview ===
    let photos = [], videos = [];

    function refreshPreview(type) {
        const container = document.getElementById(type === 'photo' ? 'preview-images' : 'preview-videos');
        container.innerHTML = '';
        const files = type === 'photo' ? photos : videos;

        files.forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <div class="h-[150px] rounded overflow-hidden border-2 border-gray-300">
                        ${type === 'photo'
                            ? `<img src="${e.target.result}" class="w-full h-full object-cover">`
                            : `<video src="${e.target.result}" muted controls autoplay loop class="w-full h-full object-cover"></video>`}
                    </div>
                    <button type="button"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 remove-file"
                        data-type="${type}" data-index="${i}">×</button>`;
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('media-preview').classList.toggle('hidden', photos.length === 0 && videos.length === 0);
    }

    document.addEventListener('change', e => {
        if (e.target.id === 'photo-input') {
            photos = [...photos, ...e.target.files];
            refreshPreview('photo');
        }
        if (e.target.id === 'video-input') {
            videos = [...videos, ...e.target.files];
            refreshPreview('video');
        }
    });

    document.addEventListener('click', e => {
        const rm = e.target.closest('.remove-file');
        if (rm) {
            const type = rm.dataset.type;
            const idx = +rm.dataset.index;
            (type === 'photo' ? photos : videos).splice(idx, 1);
            refreshPreview(type);
        }
    });
</script>