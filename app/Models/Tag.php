<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && ! empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) && ! empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    /**
     * Relasi polymorphic (artikel akan menggunakan morphToMany/ taggable)
     *
     * Contoh: Article model harus mendefinisikan
     * public function tags() { return $this->morphToMany(Tag::class, 'taggable'); }
     */
    public function artikels()
    {
        return $this->morphedByMany(Artikel::class, 'taggable');
    }
}
