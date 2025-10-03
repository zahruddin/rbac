<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        Manajemen Pengguna
    </h2>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-2 sm:space-y-0">
        <div class="flex items-center space-x-2">
            @can('create-users')
                <button wire:click="create()" wire:loading.attr="disabled" wire:target="create" 
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 disabled:opacity-50 disabled:cursor-wait">
                    
                    <span wire:loading wire:target="create">Memproses...</span>

                    <span wire:loading.remove wire:target="create">Tambah User Baru</span>
                </button>
            @endcan
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari pengguna..." class="w-full sm:w-64 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
        </div>
            <div class="flex items-center space-x-2">
            <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">Tampil</label>
            <select wire:model.live="perPage" id="perPage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Nama</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Roles & Permissions</th> {{-- MODIFIKASI --}}
                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $users->firstItem() + $loop->index }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    
                    {{-- MODIFIKASI: Tampilkan roles dan direct permissions --}}
                    <td class="px-6 py-4">
                        {{-- Tampilkan Roles --}}
                        @if($user->getRoleNames()->isNotEmpty())
                            <div>
                                @foreach($user->getRoleNames() as $role)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $role }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Tampilkan Direct Permissions --}}
                        @php
                            $directPermissions = $user->getDirectPermissions();
                        @endphp
                        @if($directPermissions->isNotEmpty())
                            <div class="mt-1">
                                @foreach($directPermissions as $permission)
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-200">{{ $permission->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-right">
                        @can('update-users')
                        <button wire:click="edit({{ $user->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                        @endcan
                        @can('delete-users')
                        <button wire:click="delete({{ $user->id }})" wire:confirm="Anda yakin ingin menghapus user ini?" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Hapus</button>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td colspan="4" class="px-6 py-4 text-center">Tidak ada pengguna yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">{{ $users->links() }}</div>

    @if ($isModalOpen)
    {{-- Latar belakang overlay --}}
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            x-data="{ open: @entangle('isModalOpen') }" 
            x-show="open" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            {{-- Kontainer Modal --}}
            {{-- MODIFIKASI: Menambahkan max-h-full agar tidak melebihi tinggi layar --}}
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                
                {{-- Konten Modal Card --}}
                {{-- MODIFIKASI: Dibuat menjadi flex-col dengan tinggi terbatas (90% viewport height) --}}
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 flex flex-col max-h-[90vh]">
                    
                    {{-- 1. Modal Header (Tetap) --}}
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $editingUser ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
                        </h3>
                        <button wire:click="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            X
                        </button>
                    </div>

                    {{-- Form untuk membungkus body dan footer --}}
                    <form wire:submit="store" class="flex-1 flex flex-col overflow-hidden">
                        
                        {{-- 2. Modal Body (Area yang bisa di-scroll) --}}
                        {{-- MODIFIKASI: Diberi overflow-y-auto agar bisa di-scroll jika kontennya panjang --}}
                        <div class="p-4 md:p-5 space-y-4 overflow-y-auto">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                {{-- MODIFIKASI: Tambahkan dark:text-white --}}
                                <input wire:model="name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                {{-- MODIFIKASI: Tambahkan dark:text-white --}}
                                <input wire:model="email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                {{-- MODIFIKASI: Tambahkan dark:placeholder-gray-400 dan dark:text-white --}}
                                <input wire:model="password" type="password" id="password" placeholder="{{ $editingUser ? '(Kosongkan jika tidak diubah)' : '••••••••' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <h4 class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Roles</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ($allRoles as $role)
                                        <div>
                                            <label class="flex items-center space-x-2 text-sm text-gray-900 dark:text-gray-300">
                                                <input type="checkbox" wire:model="assignedRoles" value="{{ $role }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600">
                                                <span>{{ Str::ucfirst($role) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-4">
                                <h4 class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Hak Akses Spesifik (Permissions)</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ($allPermissions as $permission)
                                        <div>
                                            <label class="flex items-center space-x-2 text-sm text-gray-900 dark:text-gray-300">
                                                <input type="checkbox" wire:model="directPermissions" value="{{ $permission }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600">
                                                <span>{{ Str::ucfirst($permission) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- 3. Modal Footer (Tetap) --}}
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                            <button wire:click="closeModal()" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Batal</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
</div>