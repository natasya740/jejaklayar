<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudayaController extends Controller
{
    public function index()
    {
        // Nanti bisa ambil data dari model Budaya
        return view('budaya'); 
    }
}
