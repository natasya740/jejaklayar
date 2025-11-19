<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    // 1. Pastikan tabel yang digunakan adalah 'artikels'
    protected $table = 'artikels';

    // 2. Izinkan kolom ini diisi
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'image',
        'status',
        'feedback',
    ];

    // 3. Relasi: Artikel milik satu User (Penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 4. Relasi: Artikel milik satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}