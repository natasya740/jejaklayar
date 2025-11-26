<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikels';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'image',
        'status',
        'feedback',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // optional status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';

    /**
     * Auto-generate slug if empty
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug) && ! empty($model->title)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) && ! empty($model->title)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    /* ---------- Relations ---------- */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Polymorphic many-to-many: artikel <-> tags via taggables
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * If you store image path in 'image' column, helper to get full url
     */
    public function getImageUrlAttribute()
    {
        if (! $this->image) return null;
        return asset('storage/' . ltrim($this->image, '/'));
    }

    /**
     * Simple excerpt helper
     */
    public function getExcerptAttribute()
    {
        $text = strip_tags($this->content ?? '');
        return Str::limit($text, 200);
    }
}
