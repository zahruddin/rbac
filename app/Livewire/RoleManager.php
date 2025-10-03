<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // PERBAIKAN: Tambahkan WithPagination
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManager extends Component
{
    use WithPagination; // PERBAIKAN: Gunakan trait

    // Properti Form
    public $roleId, $roleName;
    public $assignedPermissions = [];
    
    // Data untuk view
    public $permissions;
    
    // State
    public $isModalOpen = false;
    public $isLoading = false; 

    // Aturan validasi
    protected function rules()
    {
        return [
            // PERBAIKAN: Tambahkan validasi unik
            'roleName' => 'required|string|min:3|unique:roles,name,' . $this->roleId,
            'assignedPermissions' => 'nullable|array'
        ];
    }

    public function mount()
    {
        // Hanya perlu mengambil permissions sekali saja
        $this->permissions = Permission::all();
    }

    public function render()
    {
        // PERBAIKAN: Ambil data dengan paginasi
        $roles = Role::withCount('permissions')->paginate(10); // PERBAIKAN: Gunakan withCount untuk optimasi

        return view('livewire.role-manager', [
            'roles' => $roles
        ])->layout('layouts.app');
    }

    public function create()
    {
        // PERBAIKAN: Tambahkan otorisasi
        abort_unless(auth()->user()->can('create-roles'), 403, 'Anda tidak memiliki izin untuk membuat role.');
        $this->resetForm();
        $this->isLoading = true;     // <-- Set loading jadi true
        $this->isModalOpen = true;   // <-- Langsung buka modal
        $this->isLoading = false;    // <-- Set loading jadi false setelah data siap
    }

    public function edit(Role $role) // PERBAIKAN: Gunakan Route Model Binding
    {
        abort_unless(auth()->user()->can('update-roles'), 403, 'Anda tidak memiliki izin untuk mengedit role.');

        $this->roleId = $role->id;
        $this->roleName = $role->name;
        $this->assignedPermissions = $role->permissions->pluck('name')->toArray();
        $this->isLoading = true;     // <-- Set loading jadi true
        $this->isModalOpen = true;   // <-- Langsung buka modal
        $this->isLoading = false;    
    }

    public function store()
    {
        // PERBAIKAN: Tambahkan otorisasi
        $permission = $this->roleId ? 'update-roles' : 'create-roles';
        abort_unless(auth()->user()->can($permission), 403, 'Anda tidak memiliki izin untuk menyimpan role.');

        $validated = $this->validate();

        $role = Role::updateOrCreate(['id' => $this->roleId], ['name' => $validated['roleName']]);
        $role->syncPermissions($validated['assignedPermissions']);

        session()->flash('success', $this->roleId ? 'Role berhasil diperbarui.' : 'Role berhasil ditambahkan.');
        
        $this->closeModal();
        $this->dispatch('role-saved-close-modal'); // PERBAIKAN: Kirim event untuk Alpine.js
    }
    
    public function delete(Role $role) // PERBAIKAN: Gunakan Route Model Binding
    {
        // PERBAIKAN: Tambahkan otorisasi
        abort_unless(auth()->user()->can('delete-roles'), 403, 'Anda tidak memiliki izin untuk menghapus role.');

        if (in_array($role->name, ['super-admin'])) {
            session()->flash('error', 'Role Super Admin tidak dapat dihapus.');
            return;
        }

        $role->delete();
        session()->flash('success', 'Role berhasil dihapus.');
    }

    // Fungsi bantuan
    public function closeModal() {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->roleId = null;
        $this->roleName = '';
        $this->assignedPermissions = [];
        $this->resetErrorBag();
    }
}

