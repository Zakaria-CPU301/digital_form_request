<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link 
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" 
        rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    class="font-sans text-gray-900 antialiased max-h-screen" 
    style="background: url('{{ asset('img/bg.webp') }}') no-repeat center center / cover;"
>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            {{ $slot }}
        </div>
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
    </script>
</body>
</html>