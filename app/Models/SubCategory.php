<?php

/**
 * SubCategory model.
 *
 * Mewakili sub kategori konten (misalnya: Seni, Adat, Rumah Adat) dengan
 * opsi gambar thumbnail, relasi ke Category dan Article, serta auto-slug.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image', // path file gambar di disk 'public'
    ];

    /**
     * Relasi ke Category (setiap sub kategori milik satu kategori).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke Article (satu sub kategori bisa punya banyak artikel).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Accessor untuk mendapatkan URL publik gambar thumbnail.
     *
     * Contoh penggunaan di Blade:
     *   {{ $subCategory->image_url }}
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        // Asumsi file disimpan di storage/app/public
        return asset('storage/' . $this->image);
    }

    /**
     * Boot method model.
     *
     * Mengatur auto-generate slug dari name saat create/update.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Auto set slug saat create jika belum diisi
        static::creating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $subCategory->slug = Str::slug($subCategory->name);
            }
        });

        // Update slug jika name berubah
        static::updating(function ($subCategory) {
            if ($subCategory->isDirty('name')) {
                $subCategory->slug = Str::slug($subCategory->name);
            }
        });
    }
}