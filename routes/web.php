<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\UserTable;
use App\Livewire\RoleManager;
use App\Livewire\Settings\GeneralSettingsManager;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/site-closed', function () {
    return view('site-closed');
})->name('site.closed'); 

// Grup untuk semua rute yang membutuhkan login
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Satu route dashboard untuk semua. Controller akan menampilkan view yang sesuai.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route profile umum
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route manajemen, dilindungi oleh middleware permission
    // Hanya pengguna dengan izin 'read-users' yang bisa mengakses /users
    Route::get('/users', UserTable::class)->name('users.index')->middleware('permission:read-users');
    
    // Hanya pengguna dengan izin 'manage-roles' yang bisa mengakses /roles
    Route::get('/roles', RoleManager::class)->name('roles.index')->middleware('permission:read-roles');
    
    Route::get('settings/general', GeneralSettingsManager::class)->name('settings.general')->middleware('permission:read-general-settings');
});

require __DIR__.'/auth.php';