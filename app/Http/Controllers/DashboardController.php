<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard generik.
     */
    public function index()
    {
        // Untuk sementara, kita hanya akan menampilkan satu view yang sama
        // untuk semua role agar tidak terjadi error.
        return view('dashboard');
    }
}