<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // === AWAL PERUBAHAN ===

        // 1. Ambil pengguna yang baru saja login
        $user = $request->user();

        // 2. Ambil role pertama dari pengguna tersebut
        $role = $user->getRoleNames()->first();

        // 3. Tentukan route tujuan berdasarkan role
        //    Jika user punya role, arahkan ke 'role.dashboard' (cth: 'admin.dashboard')
        //    Jika tidak punya role, arahkan ke 'dashboard' biasa sebagai fallback
        $dashboardRoute = 'dashboard';

        // 4. Arahkan pengguna ke route yang sudah ditentukan
        return redirect()->intended(route($dashboardRoute, absolute: false));

        // === AKHIR PERUBAHAN ===
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
