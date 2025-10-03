<x-app-layout>
    {{-- Slot untuk judul tab browser --}}
    <x-slot:title>
        Dashboard
    </x-slot:title>

    {{-- Header Selamat Datang --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Selamat Datang Kembali, {{ Auth::user()->name }}!
        </h2>
        <p class="text-gray-500 dark:text-gray-400">
            Anda login sebagai: 
            <span class="font-semibold text-primary-600 dark:text-primary-500">{{ Str::ucfirst(Auth::user()->getRoleNames()->first()) }}</span>
        </p>
    </div>

    {{-- ====================================================================== --}}
    {{-- Tampilan Dashboard untuk Role ADMIN --}}
    {{-- ====================================================================== --}}
    @role('admin')
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Total Mahasiswa Aktif</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">1,250</p> {{-- Ganti dengan data asli --}}
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Total Dosen</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">150</p> {{-- Ganti dengan data asli --}}
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Program Studi</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">12</p> {{-- Ganti dengan data asli --}}
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Pengguna Baru (24 Jam)</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">5</p> {{-- Ganti dengan data asli --}}
            </div>
        </div>
        
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pintasan Cepat</h3>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('users.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Manajemen Pengguna</a>
                <a href="#" class="text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">Kelola Role & Permission</a>
                <a href="#" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">Lihat Log Aktivitas</a>
            </div>
        </div>
    </div>
    @endrole

    {{-- ====================================================================== --}}
    {{-- Tampilan Dashboard untuk Role DOSEN --}}
    {{-- ====================================================================== --}}
    @role('dosen')
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Mahasiswa Bimbingan</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">25</p> {{-- Ganti dengan data asli --}}
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">KRS Perlu Persetujuan</h3>
                <p class="text-3xl font-bold text-primary-600 dark:text-primary-500 mt-2">3</p> {{-- Ganti dengan data asli --}}
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Jadwal Mengajar Hari Ini</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">2</p> {{-- Ganti dengan data asli --}}
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Jadwal Mengajar Hari Ini</h3>
                <ul class="space-y-3">
                    {{-- Ganti dengan loop data asli dari database --}}
                    <li class="p-3 bg-gray-50 rounded-lg dark:bg-gray-700"><strong>10:00 - 12:00:</strong> Kalkulus II (Ruang 301)</li>
                    <li class="p-3 bg-gray-50 rounded-lg dark:bg-gray-700"><strong>14:00 - 16:00:</strong> Algoritma & Pemrograman (Ruang 205)</li>
                </ul>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pengumuman Terbaru</h3>
                <ul class="space-y-3">
                    {{-- Ganti dengan loop data asli dari database --}}
                    <li class="text-sm">Rapat Dosen Jurusan Teknik Informatika - 2 Oktober 2025</li>
                    <li class="text-sm">Batas Akhir Pengisian Nilai Semester Ganjil - 15 Oktober 2025</li>
                </ul>
            </div>
        </div>
    </div>
    @endrole

    {{-- ====================================================================== --}}
    {{-- Tampilan Dashboard untuk Role MAHASISWA --}}
    {{-- ====================================================================== --}}
    @role('mahasiswa')
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Indeks Prestasi (IPK)</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">3.75</p> {{-- Ganti dengan data asli --}}
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Total SKS Ditempuh</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">98</p> {{-- Ganti dengan data asli --}}
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-500 dark:text-gray-400">Status KRS</h3>
                <p class="text-lg font-semibold text-green-600 dark:text-green-500 mt-2">Disetujui</p> {{-- Ganti dengan data asli --}}
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Jadwal Kuliah Hari Ini</h3>
                <ul class="space-y-3">
                    {{-- Ganti dengan loop data asli dari database --}}
                    <li class="p-3 bg-gray-50 rounded-lg dark:bg-gray-700"><strong>08:00 - 10:00:</strong> Basis Data (Ruang 101)</li>
                    <li class="p-3 bg-gray-50 rounded-lg dark:bg-gray-700"><strong>13:00 - 15:00:</strong> Jaringan Komputer (Lab Komputer 2)</li>
                </ul>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Pengumuman Akademik</h3>
                <ul class="space-y-3">
                    {{-- Ganti dengan loop data asli dari database --}}
                    <li class="text-sm">Batas Akhir Pembayaran UKT Semester Genap - 10 Oktober 2025</li>
                    <li class="text-sm">Pendaftaran Wisuda Periode IV Telah Dibuka</li>
                </ul>
            </div>
        </div>
    </div>
    @endrole

</x-app-layout>