<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

        <style>
            body {
                font-family: 'Geologica', sans-serif;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-geologica antialiased">
        <div class="min-h-screen w-full bg-gradient-to-r from-[#B3C4DE] to-[#EAEFF6]" x-data="{ sidebarOpen: true }" x-on:open-sidebar.window="sidebarOpen = true" x-on:close-sidebar.window="sidebarOpen = false">
            @include('layouts.navbar', ['sidebarOpen' => 'sidebarOpen'])
            @include('layouts.sidebar', ['sidebarOpen' => 'sidebarOpen'])

            <main :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'" class="ml-72 min-h-screen max-w-full flex flex-col items-center mt-20 px-4 sm:px-6 lg:px-8 transition-all duration-300 ease-in-out">
                <div :class="sidebarOpen ? 'max-w-5xl' : 'max-w-6xl'" class="w-full max-w-6xl rounded-xl overflow-hidden shadow-lg bg-white mx-auto py-6 sm:py-8 lg:py-12 px-4 sm:px-6 lg:px-10 transition-all duration-300 ease-in-out">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
