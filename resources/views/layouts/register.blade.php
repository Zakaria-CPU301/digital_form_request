<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/png">
        <title>Sangnila E-form</title>
            <style>
        body {
            font-family: 'Geologica', sans-serif;
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
        <div class="min-h-screen bg-gradient-to-r from-[#B3C4DE] to-[#EAEFF6]">
            @include('layouts.navbar')
            @include('layouts.sidebar')

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <div id="global-loading" 
         class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
        <div class="w-6 h-6 border-4 rounded-full animate-spin border-sky-600 border-t-transparent"></div>
    </div>

    <!-- Script -->
    <script>
      function showLoading() {
        document.getElementById('global-loading').classList.remove('hidden');
      }
      function hideLoading() {
        document.getElementById('global-loading').classList.add('hidden');
      }

      // Spinner hilang setelah semua resource selesai dimuat
      window.addEventListener('load', () => {
        hideLoading();
      });

      // Spinner muncul saat submit form
      document.addEventListener('submit', function () {
        showLoading();
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
