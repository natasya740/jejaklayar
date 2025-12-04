<?php
// app/Models/File.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'id',
        'filepath',
        'fileable_id',
        'fileable_type'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });

        // Hapus file saat record dihapus
        static::deleting(function ($model) {
            if (Storage::exists($model->filepath)) {
                Storage::delete($model->filepath);
            }
        });
    }

    public function fileable()
    {
        return $this->morphTo();
    }

    // Accessor untuk mendapatkan URL file
    public function getUrlAttribute()
    {
        return Storage::url($this->filepath);
    }

    // Accessor untuk mendapatkan full URL
    public function getFullUrlAttribute()
    {
        return asset('storage/' . $this->filepath);
    }
}