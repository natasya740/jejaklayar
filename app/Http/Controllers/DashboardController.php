<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Halaman utama dashboard
    public function index()
    {
        return view('dashboard');
    }

    // Jika route memanggil DashboardController@home
    public function home()
    {
        return view('home');
    }
}
