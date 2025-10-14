@if (session('success'))
    <script>
        window.addEventListener('load', function() {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'success-modal' }));
        });
    </script>
@elseif (session('fail'))
    <script>
        window.addEventListener('load', function() {
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'success-modal' }));
        });
    </script>
@endif

<x-modal name="success-modal" maxWidth="2xl">
    <div class="p-4">
        <!-- Tombol close -->
        <div class="flex justify-end">
            <button
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'success-modal' }))"
                class="text-red-500 hover:text-red-300 text-3xl font-bold"
            >
                &times;
            </button>
        </div>

        <!-- Konten utama -->
        <div class="flex items-center justify-center p-5">
            <!-- Icon centang -->
            <div class="flex-shrink-0">
                @if (session('success'))
                    <svg class="w-40 h-40 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                @elseif (session('fail'))
                    <svg class="w-40 h-40 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @endif
            </div>

            <!-- Teks -->
            <div class="ml-8">
                @php
                $success = session()->pull('success');
                $fail = session()->pull('fail');
                @endphp
                @if ($success)
                    <h2 class="text-3xl font-bold text-[#012967] mb-5 capitalize">{{$success['title']}}</h2>
                    <p class="text-lg text-[#1EB8CD] mb-2">{{$success['message']}}</p>
                    @if (isset($success['time']))
                        <p class="text-sm text-gray-500">
                            Submitted at:
                            <span class="font-medium text-gray-700">
                                {{$success['time']}} 
                            </span>
                        </p>
                    @endif
                @elseif ($fail)
                    <h2 class="text-3xl font-bold text-[#012967] mb-5 capitalize">{{$fail['title']}}</h2>
                    <p class="text-lg text-[#1EB8CD] mb-2">{{$fail['message']}}</p>
                    @if(isset($fail['time']))
                        <p class="text-sm text-gray-500">
                            Submitted at:
                            <span class="font-medium text-gray-700">
                                {{$fail['time']}} 
                            </span>
                        </p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-modal>