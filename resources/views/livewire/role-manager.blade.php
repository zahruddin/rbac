<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        Manajemen Role & Permission
    </h2>
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 space-y-2 sm:space-y-0">
        @can('create-roles')
            <button wire:click="create()" wire:loading.attr="disabled" wire:target="create" 
                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 disabled:opacity-50 disabled:cursor-wait">
                
                <span wire:loading wire:target="create">Memproses...</span>

                <span wire:loading.remove wire:target="create">Tambah Role Baru</span>
            </button>
        @endcan
    </div>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Nama Role</th>
                    <th scope="col" class="px-6 py-3">Permissions</th>
                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{ $roles->firstItem() + $loop->index }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $role->name }}</td>
                    <td class="px-6 py-4">
                        @foreach ($role->permissions->take(5) as $permission)
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $permission->name }}</span>
                        @endforeach
                        @if ($role->permissions->count() > 5)
                            <span class="text-xs text-gray-500 dark:text-gray-400">+{{ $role->permissions->count() - 5 }} lagi</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @can('update-roles')
                            <button wire:click="edit({{ $role->id }})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                        @endcan
                        @can('delete-roles')
                            <button wire:click="delete({{ $role->id }})" wire:confirm="Anda yakin ingin menghapus role ini?" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Hapus</button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-2xl">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    {{-- Bagian Header Modal (tetap sama) --}}
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $roleId ? 'Edit Role' : 'Tambah Role Baru' }}
                        </h3>
                        <button wire:click="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    
                    {{-- Bagian Form --}}
                    <form wire:submit.prevent="store">
                        <div class="p-4 md:p-5 space-y-4">
                            
                            @if ($isLoading)
                                <div class="space-y-4 animate-pulse">
                                    {{-- Skeleton untuk Input Nama Role --}}
                                    <div>
                                        <div class="h-4 bg-gray-200 rounded w-1/4 mb-2"></div>
                                        <div class="h-10 bg-gray-200 rounded w-full"></div>
                                    </div>
                                    {{-- Skeleton untuk Permissions --}}
                                    <div>
                                        <div class="h-4 bg-gray-200 rounded w-1/3 mb-3"></div>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @for ($i = 0; $i < 8; $i++)
                                            <div class="flex items-center space-x-2">
                                                <div class="h-5 w-5 bg-gray-200 rounded"></div>
                                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div>
                                    <label for="roleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Role</label>
                                    <input wire:model.defer="roleName" type="text" id="roleName" class="bg-gray-50 border ... w-full" required>
                                    @error('roleName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <h4 class="mb-2 text-sm font-medium text-gray-900 dark:text-white">Assign Permissions</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($permissions as $permission)
                                        <div>
                                            <label class="flex items-center space-x-2 text-sm text-gray-900 dark:text-gray-300">
                                                <input type="checkbox" wire:model.defer="assignedPermissions" value="{{ $permission->name }}" class="rounded ...">
                                                <span>{{ $permission->name }}</span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                        
                        {{-- Bagian Footer Modal (Tombol) --}}
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button type="submit" 
                                    class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-wait"
                                    {{ $isLoading ? 'disabled' : '' }}>
                                Simpan
                            </button>
                            <button wire:click="closeModal()" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 ...">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>