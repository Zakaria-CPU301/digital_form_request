<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account Suspended</title>
    
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        
</head>
<body class="bg-blue-50 text-gray-800 font-sans min-h-screen flex flex-col justify-between">

    <div class="flex-grow flex items-center justify-center px-4">
        <div class="bg-white shadow-lg rounded-lg max-w-md w-full p-6 text-center">
            <img src="https://cdn3.iconfinder.com/data/icons/actions-alphabet-s-set-50-of-52/433/actions-S-50-8-1024.png" alt="Account Suspended" class="w-24 mx-auto mb-4" />

            <h2 class="text-2xl font-semibold text-blue-700 mb-2">Account Suspended</h2>
            <p class="text-sm text-gray-600 mb-6">
                Your account has been suspended by the administrator. This may be due to policy violations or other administrative reasons.
            </p>

            <div class="space-y-3">
                {{-- <a href="{{ route('contact.admin') }}" class="block w-full bg-yellow-400 hover:bg-yellow-500 text-black font-medium py-2 px-4 rounded transition">Contact Admin</a> --}}
                <a href="{{ route('login') }}" class="block w-full border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-medium py-2 px-4 rounded transition">Back to Login</a>
            </div>

            <hr class="my-6 border-t border-gray-200" />

            <p class="text-xs text-gray-500">
                If you believe this is a mistake, please contact our support team for further assistance.
            </p>
        </div>
    </div>

    <footer class="text-center text-sm text-gray-400 py-4">
        &copy; {{ date('Y') }} PT Sangnila Utama. All Rights Reserved.
    </footer>

</body>
</html>
