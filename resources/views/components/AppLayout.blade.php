<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
            <style>
        body {
            font-family: 'Geologica', sans-serif;
            scroll-behavior: smooth;
        }
    </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Geologica&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-h-screen bg-gradient-to-r from-[#B3C4DE] to-[#EAEFF6]" x-data="{ sidebarOpen: true }" x-on:open-sidebar.window="sidebarOpen = true" x-on:close-sidebar.window="sidebarOpen = false">
                @include('layouts.navbar', ['sidebarOpen' => 'sidebarOpen'])

                <!-- Include sidebar with state sharing -->
                @include('layouts.sidebar', ['sidebarOpen' => 'sidebarOpen'])

            <!-- Page Content with reactive margin -->
            <main :class="sidebarOpen ? 'ml-72' : 'ml-0'" class="transition-all duration-300 ease-in-out">
                <div :class="sidebarOpen ? 'max-w-5xl' : 'max-w-6xl'" class="w-full mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300 ease-in-out">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
