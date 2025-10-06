<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Auth;

class CheckSiteStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Definisikan rute yang diizinkan saat situs ditutup
        $allowedRoutes = ['site.closed', 'logout']; // Termasuk logout
        
        // Cek apakah request saat ini menuju ke rute yang diizinkan.
        // Jika ya, langsung proses tanpa pengecekan status situs.
        if ($request->routeIs($allowedRoutes)) {
            return $next($request);
        }

        // Ambil objek GeneralSettings
        $settings = app(GeneralSettings::class);

        // 2. Cek apakah situs tidak aktif (Maintenance Mode)
        if (!$settings->site_active) {
            
            // 3. Jika situs tidak aktif, cek apakah user adalah Super Admin
            if (Auth::check() && Auth::user()->hasRole('super-admin')) {
                // Biarkan Super Admin lewat
                return $next($request);
            }

            // 4. Jika situs tidak aktif dan user BUKAN Super Admin:
            // Arahkan ke rute Maintenance
            return redirect()->route('site.closed');
        }

        // Jika situs aktif, lanjutkan permintaan
        return $next($request);
    }
}
