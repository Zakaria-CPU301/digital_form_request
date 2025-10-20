<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/icon.png') }}" type="image/png">
    <title>Sangnila E-form</title>

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