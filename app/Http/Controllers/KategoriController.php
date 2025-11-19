<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function getSubKategori(Kategori $kategori)
    {
        return response()->json($kategori->children);
    }
}