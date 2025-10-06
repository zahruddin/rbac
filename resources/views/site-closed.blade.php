<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="p-8 bg-white dark:bg-gray-800 shadow-xl rounded-lg text-center mx-4 max-w-lg w-full">
            
            <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.352 17c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">Sistem Ditutup Sementara</h1>
            
            <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
                Mohon maaf, Sistem Informasi Akademik saat ini sedang dalam **mode pemeliharaan dan perbaikan**.
            </p>
            
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Kami mohon kesabarannya. Layanan akan kembali normal secepatnya.
            </p>
            
            <div class="mt-8">
                <!-- Tambahkan tombol untuk mencoba login lagi -->
                <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 font-medium transition duration-150 ease-in-out">
                    Coba Akses Lagi →
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
