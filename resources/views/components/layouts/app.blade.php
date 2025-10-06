<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    @auth
    @php
        // Ambil role pertama dari pengguna yang sedang login
        $role = Auth::user()->getRoleNames()->first();
    @endphp
    @endauth

    <x-layouts.navbar />

    {{-- Sidebar hanya untuk user yang sudah login --}}

    @auth
        <x-layouts.sidebar />
    @endauth

    <div class="p-4 sm:ml-64">
    <div class="rounded-lg mt-16">
            {{ $slot }}
    </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        const themeToggleBtn = document.getElementById('theme-toggle');

        // Tentukan ikon mana yang akan ditampilkan saat halaman pertama kali dimuat
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        // Tambahkan event listener untuk tombol
        themeToggleBtn.addEventListener('click', function() {
            // Ganti ikon di dalam tombol
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // Periksa apakah kelas 'dark' sudah ada di <html>
            if (document.documentElement.classList.contains('dark')) {
                // Jika ADA, maka hapus kelas 'dark' dan simpan 'light' di localStorage
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                // Jika TIDAK ADA, maka tambahkan kelas 'dark' dan simpan 'dark' di localStorage
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });
    </script>
    @livewireScripts
</body>
</html>