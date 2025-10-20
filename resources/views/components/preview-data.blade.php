<x-modal name="dashboard-preview-modal" maxWidth="3xl">
    <div class="p-6 flex flex-col max-h-[80vh]">
        <div class="flex justify-between items-center mb-4 flex-shrink-0">
            <h3
                class="text-xl font-extrabold text-[#012967] flex-1 text-center"
            >
                Request Preview
            </h3>
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'dashboard-preview-modal' }))"
                class="text-red-500 hover:text-red-300 text-2xl"
            >
                &times;
            </button>
        </div>
        <div
            id="dashboard-preview-body"
            class="space-y-3 overflow-y-auto flex-1"
        >
            <!-- content -->
        </div>
    </div>
</x-modal>

<x-modal name="evidence-viewer-modal" maxWidth="6xl">
    <div class="flex items-center justify-center relative p-6">
        <button
            @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'evidence-viewer-modal' }))"
            class="absolute right-5 m-5 top-0 text-red-500 hover:text-red-300 text-2xl"
        >
            &times;
        </button>
        <div id="evidence-viewer-body" class="flex items-center justify-center">
            <!-- media content -->
        </div>
        <button
            id="prev-evidence"
            class="absolute left-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded"
        >
            &larr;
        </button>
        <button
            id="next-evidence"
            class="absolute right-4 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded"
        >
            &rarr;
        </button>
    </div>
</x-modal>
