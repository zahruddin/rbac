@extends('layouts.app') 

{{-- Anda bisa mengatur bagian-bagian layout di sini, jika layout Anda mendukung @section --}}

@section('content')
    <div class="p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4 dark:text-gray-900">Pengaturan Umum Aplikasi</h1>

        {{-- Panggil komponen Livewire Spatie Settings Anda di sini --}}
        <livewire:general-settings-manager />
    </div>
@endsection