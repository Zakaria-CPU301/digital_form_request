<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account Suspended</title>

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
            <img src="{{ asset('img/suspended_icon.webp') }}" alt="Account Suspended" class="w-32 mx-auto mb-6 opacity-90" />

            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-[#012967] mb-3">Account Suspended</h2>
                <p class="text-sm text-gray-600 mb-1">
                    Your account has been suspended by the administrator.
                </p>
                <p class="text-sm text-gray-600">
                    This may be due to policy violations or other administrative reasons.
                </p>
            </div>

            <div class="space-y-3 mb-6">
                <a href="https://wa.link/cewipg" class="block w-full bg-sky-100 text-[#012967] font-medium py-2 px-4 rounded-md border border-sky-200 hover:bg-sky-200 transition duration-150 ease-in-out">
                    Contact Admin
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="block w-full bg-white border border-sky-700 text-[#012967] hover:bg-[#012967] hover:text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Back to Login
                    </button>
                </form>
            </div>

            <hr class="my-6 border-gray-200" />

            <p class="text-xs text-gray-500 leading-relaxed">
                If you believe this is a mistake, please contact our support team for further assistance.
            </p>
        </div>
    </div>
    
    
    <footer class="text-center text-sm text-gray-400 py-6">
        &copy; {{ date('Y') }} PT Sangnila Utama. All rights reserved.
    </footer>

</body>
</html>
