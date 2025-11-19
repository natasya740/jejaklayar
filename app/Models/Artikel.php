<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel database yang digunakan oleh model ini.
     * (Wajib jika nama tabel Anda 'artikel', bukan 'artikels')
     */
    protected $table = 'artikel';

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'slug',
        'isi',
        'status',
        'gambar_header',
    ];

    /**
     * Relasi: Satu Artikel dimiliki oleh satu User.
     * Ini memungkinkan Anda memanggil $artikel->user->nama
     */
    public function user()
    {
        // terhubung ke Model 'User', foreign key 'user_id'
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Satu Artikel dimiliki oleh satu Kategori.
     * Ini memungkinkan Anda memanggil $artikel->kategori->nama
     */
    public function kategori()
    {
        // terhubung ke Model 'Kategori', foreign key 'kategori_id'
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}