<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Form Request</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link 
        href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" 
        rel="stylesheet" 
    />
    <link 
        href="https://fonts.googleapis.com/css2?family=Geologica:wght@400;600;700&display=swap" 
        rel="stylesheet"
    />

    <style>
        body {
            font-family: 'Geologica', sans-serif;
        }
    </style>

    <!-- Bootstrap Icons -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <!-- Tailwind CDN (optional, disable if using Vite build) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="container w-full min-h-screen flex justify-center items-center bg-gradient-to-r from-[#B3C4DE] to-[#EAEFF6]">
        @yield('content')
    </div>
</body>
</html>
