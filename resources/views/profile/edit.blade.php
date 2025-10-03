<x-app-layout>
    {{-- Slot untuk judul tab browser --}}
    <x-slot:title>
        Profile
    </x-slot:title>

    {{-- Judul halaman, sekarang ditempatkan di dalam konten utama --}}
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-6">
        {{ __('Profile') }}
    </h2>

    <div class="space-y-6">
        {{-- Card untuk Update Profile Information --}}
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Card untuk Update Password --}}
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Card untuk Delete Account --}}
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

</x-app-layout>