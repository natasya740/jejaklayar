<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PustakaController extends Controller
{
    public function index()
    {
        // Nanti bisa ambil data dari model Pustaka
        return view('pustaka');
    }
}
