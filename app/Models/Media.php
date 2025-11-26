<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'filename',
        'path',
        'mime',
        'size',
        'user_id',
    ];

    /**
     * Owner user (nullable)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Full url helper (asset storage)
     * usage: $media->url
     */
    public function getUrlAttribute()
    {
        // Pastikan 'storage' linked: php artisan storage:link
        return asset('storage/' . ltrim($this->path, '/'));
    }

    /**
     * Short helper to return human readable size (optional)
     */
    public function getHumanSizeAttribute()
    {
        $size = $this->size ?? 0;
        if ($size >= 1073741824) return round($size / 1073741824, 2).' GB';
        if ($size >= 1048576)    return round($size / 1048576, 2).' MB';
        if ($size >= 1024)       return round($size / 1024, 2).' KB';
        return $size . ' B';
    }
}
