<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

});

// Dashboard untuk semua role
try {
    $roles = Role::pluck('name'); // ambil semua role dari DB
} catch (\Exception $e) {
    $roles = collect([]); // fallback kalau DB belum ready (misal fresh install)
}

foreach ($roles as $role) {
    Route::prefix($role)
        ->middleware(['auth', "role:$role"])
        ->name($role . '.') // supaya bisa pakai route('admin.dashboard')
        ->group(function () use ($role) {
            Route::get('/dashboard', fn () => view('dashboard', ['role' => $role]))
                ->name('dashboard');

            Route::get('/profile', [ProfileController::class, 'edit'])
                ->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])
                ->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])
                ->name('profile.destroy');
        });
}




// // Admin profile
// Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
// });

// // Dosen profile
// Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('dosen.profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('dosen.profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('dosen.profile.destroy');
// });

// // Mahasiswa profile
// Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('mahasiswa.profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('mahasiswa.profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('mahasiswa.profile.destroy');
// });


require __DIR__.'/auth.php';
