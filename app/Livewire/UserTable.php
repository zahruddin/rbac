<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission; // BARU: Import model Permission

class UserTable extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10; 
    public ?User $editingUser = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    
    // Properti untuk Roles
    public array $assignedRoles = [];
    public $allRoles;

    // BARU: Properti untuk Direct Permissions
    public array $directPermissions = [];
    public $allPermissions;

    public $isModalOpen = false;
    public $isLoading = false; 


    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->editingUser ? $this->editingUser->id : 'NULL'),
            'password' => $this->editingUser ? 'nullable|min:8' : 'required|min:8',
            'assignedRoles' => 'nullable|array',
            'directPermissions' => 'nullable|array', // BARU: Aturan validasi untuk permissions
        ];
    }
    public function mount()
    {
        $this->allRoles = Role::pluck('name');
        $this->allPermissions = Permission::pluck('name'); // BARU: Ambil semua nama permission
    }
    public function create()
    {
        abort_unless(auth()->user()->can('create-users'), 403);
        $this->resetForm();
        $this->isLoading = true;     // <-- Set loading jadi true
        $this->isModalOpen = true;
        $this->isLoading = false;    // <-- Set loading jadi false setelah data siap

    }
    public function edit(User $user)
    {
        abort_unless(auth()->user()->can('update-users'), 403);
        
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->assignedRoles = $user->getRoleNames()->toArray();
        $this->directPermissions = $user->getDirectPermissions()->pluck('name')->toArray(); // BARU: Ambil direct permissions milik user
        $this->isModalOpen = true;
    }
    public function store()
    {
        $this->validate();

        if ($this->editingUser) {
            // Logika untuk Update
            abort_unless(auth()->user()->can('update-users'), 403);
            
            $this->editingUser->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);
            
            if (!empty($this->password)) {
                $this->editingUser->update(['password' => Hash::make($this->password)]);
            }

            $this->editingUser->syncRoles($this->assignedRoles);
            $this->editingUser->syncPermissions($this->directPermissions); // BARU: Sinkronisasi direct permissions

            session()->flash('success', 'User berhasil diperbarui.');

        } else {
            // Logika untuk Create
            abort_unless(auth()->user()->can('create-users'), 403);

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            $user->syncRoles($this->assignedRoles);
            $user->syncPermissions($this->directPermissions); // BARU: Sinkronisasi direct permissions

            session()->flash('success', 'User berhasil ditambahkan.');
        }

        $this->closeModal();
    }
    public function delete(User $user)
    {
        abort_unless(auth()->user()->can('delete-users'), 403);
        $user->delete();
        session()->flash('success', 'User berhasil dihapus.');
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }
    private function resetForm()
    {
        // MODIFIKASI: Tambahkan directPermissions ke reset
        $this->reset(['editingUser', 'name', 'email', 'password', 'assignedRoles', 'directPermissions']);
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::query()
            ->with('roles', 'permissions')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%'))
            ->paginate($this->perPage); // MODIFIKASI: Gunakan properti $perPage
            
        return view('livewire.user-table', [
            'users' => $users
        ])->layout('components.layouts.app');
    }
}