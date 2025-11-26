<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name','slug','description','parent_id'];

    protected static function booted()
    {
        static::creating(function ($m) {
            if (empty($m->slug) && ! empty($m->name)) $m->slug = Str::slug($m->name);
        });
        static::updating(function ($m) {
            if (empty($m->slug) && ! empty($m->name)) $m->slug = Str::slug($m->name);
        });
    }

    public function parent() { return $this->belongsTo(self::class, 'parent_id'); }
    public function children() { return $this->hasMany(self::class, 'parent_id'); }
    public function artikels() { return $this->hasMany(Artikel::class); }

    public function isDescendantOf(Category $possibleParent): bool
    {
        $node = $this;
        while ($node && $node->parent) {
            if ($node->parent->id === $possibleParent->id) return true;
            $node = $node->parent;
        }
        return false;
    }
}
