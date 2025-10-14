<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/png">

        <title>Sangnila E-Form</title>
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
      <x-header />
      <div class="min-h-screen bg-gradient-to-r from-[#B3C4DE] to-[#EAEFF6]" x-data="{ sidebarOpen: true }" x-on:open-sidebar.window="sidebarOpen = true" x-on:close-sidebar.window="sidebarOpen = false">
                @include('layouts.navbar')

                <!-- Include sidebar with state sharing -->
                @include('layouts.sidebar', ['sidebarOpen' => 'sidebarOpen'])

            <!-- Page Content with reactive margin -->
            <main :class="sidebarOpen ? 'ml-0' : 'ml-[-0px]'" class="ml-72 transition-all duration-300 ease-in-out pb-10">
                {{ $slot }}
            </main>
        </div>
        <div id="global-loading" 
         class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
        <div class="w-6 h-6 border-4 rounded-full animate-spin border-sky-600 border-t-transparent"></div>
    </div>

    <!-- Script -->
    <script>
       const loader = document.getElementById('global-loading');

  function showLoading() {
    loader.classList.remove('hidden');
  }
  function hideLoading() {
    loader.classList.add('hidden');
  }

  // === 1. Tampilin spinner secepat mungkin pas halaman mulai load
  document.addEventListener('DOMContentLoaded', () => {
    showLoading();
  });

  // === 2. Hilangin pas semua resource udah siap
  window.addEventListener('load', () => {
    hideLoading();
  });

  // === 3. Tampil lagi kalau user submit form
  document.addEventListener('submit', (e) => {
    // biar gak bentrok sama ajax / validation JS
    setTimeout(() => showLoading(), 50);
  });
      document.querySelectorAll('a[href]').forEach(a => {
  a.addEventListener('click', e => {
    const href = a.getAttribute('href');
    if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
      showLoading();
    }
  });
});
    </script>
    </body>
</html>
