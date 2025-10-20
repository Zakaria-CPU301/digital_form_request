<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Leave Limit Reached</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body>
    <div 
        class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('{{ asset('img/bg.webp') }}');"
    >
        <div class="min-h-screen flex flex-col justify-between">
            <div class="flex-grow flex flex-col items-center justify-center px-4 py-10">
                <div class="bg-white shadow-md rounded-xl max-w-md w-full p-8 text-center border border-gray-200">
                    <img src="https://cdn-icons-png.flaticon.com/512/463/463612.png" 
                         alt="Leave Limit Reached" 
                         class="w-24 mx-auto mb-6 opacity-90" />

                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold text-[#012967] mb-3">Leave Limit Has Been Reached</h2>
                        <p class="text-sm text-gray-600 mb-1">
                            You've reached the maximum number of leave requests allowed.
                        </p>
                        <p class="text-sm text-gray-600">
                            Please contact the administrator if you believe this is an error or need an exception.
                        </p>
                    </div>

                    <div class="space-y-3 mb-6">
                        <a href="https://wa.link/cewipg" 
                           class="block w-full bg-sky-100 text-[#012967] font-medium py-2 px-4 rounded-md border border-sky-200 hover:bg-sky-200 transition duration-150 ease-in-out">
                            Contact Admin
                        </a>
                        <a href="{{ route('leave.show') }}" 
                           class="block w-full bg-white border border-sky-700 text-[#012967] hover:bg-[#012967] hover:text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            Back to Leave Data
                        </a>
                    </div>

                    <hr class="my-6 border-gray-200" />

                    <p class="text-xs text-gray-500 leading-relaxed">
                        Need help or want to appeal your leave status? Reach out to the admin for clarification.
                    </p>
                </div>
            </div>

            <footer class="text-center text-sm text-gray-400 py-6">
                &copy; {{ date('Y') }} PT Sangnila Utama. All rights reserved.
            </footer>
        </div>
    </div>
</body>
</html>
