<?php

namespace App\Http\Controllers\Kontributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('kontributor.profil', compact('user'));
    }

    // tambahkan edit/update jika perlu
}
