<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class KategoriController extends Controller
{
    /**
     * Mengambil sub kategori berdasarkan kategori utama
     */
    public function getSubKategori(Category $kategori)
    {
        return response()->json($kategori->children);
    }
}
