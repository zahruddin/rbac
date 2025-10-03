<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MenuComposer
{
    public function compose(View $view)
    {
        if (!Auth::check()) {
            $view->with('sidebarMenu', []);
            return;
        }

        $user = Auth::user();
        $allMenuItems = config('menu');
        $accessibleMenu = [];

        // $userPermissions = $user->getAllPermissions()->pluck('name');
        // dd([
        //     'USER_ID' => $user->id,
        //     'USER_ROLES' => $user->getRoleNames(),
        //     'USER_PERMISSIONS' => $userPermissions,
        //     'ALL_MENU_ITEMS' => $allMenuItems,
        // ]);

        foreach ($allMenuItems as $permission => $menu) {
            // Cek 1: Apakah pengguna punya permission?
            if ($user->can($permission)) {
                
                // Cek 2: Apakah route-nya ada? (Sekarang tanpa prefix role)
                $routeName = $menu['route_name']; // Langsung ambil dari config
                
                if (Route::has($routeName)) {
                    $menu['route'] = $routeName; // Simpan nama route yang sudah benar
                    $accessibleMenu[] = $menu;
                }
            }
        }

        $view->with('sidebarMenu', $accessibleMenu);
    }
}