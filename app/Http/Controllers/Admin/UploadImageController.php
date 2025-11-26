<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    /**
     * Upload image for editor (insert image button).
     * Returns JSON: { url: "/storage/..." }
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120'] // 5MB
        ]);

        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = now()->format('Ymd_His') . '_' . Str::random(8) . '.' . $ext;

        // store to storage/app/public/artikels
        $file->storeAs('public/artikels', $filename);

        // make sure storage:link is present -> /storage/artikels/...
        $url = Storage::url('artikels/' . $filename);

        return response()->json([
            'url' => $url
        ]);
    }
}
