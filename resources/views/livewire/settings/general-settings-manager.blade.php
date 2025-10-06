<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        Pengaturan Umum Sistem
    </h2>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="bg-white shadow sm:rounded-lg p-6 dark:bg-gray-800 space-y-6">

            {{-- Input: Nama Situs --}}
            <div>
                <label for="siteName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Aplikasi / Situs</label>
                <input wire:model="siteName" type="text" id="siteName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('siteName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Input: Timezone (Pilih dari daftar Timezone PHP) --}}
            <div>
                <label for="siteTimezone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Timezone Aplikasi</label>
                <select wire:model="siteTimezone" id="siteTimezone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Pilih Timezone</option>
                    {{-- Anda mungkin perlu iterasi di sini, tapi untuk demo kita bisa hardcode --}}
                    <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                    <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                    <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                </select>
                @error('siteTimezone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Input: Status Situs (Toggle Switch) --}}
            <div class="flex items-center space-x-3">
                <input wire:model="siteActive" id="siteActive" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                <label for="siteActive" class="text-sm font-medium text-gray-900 dark:text-gray-300">Situs Aktif (Izinkan Pengguna Login)</label>
                @error('siteActive') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            {{-- Tombol Simpan --}}
            <div class="border-t pt-4 dark:border-gray-700">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-wait"
                        wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
            </div>
        </div>
    </form>
</div>