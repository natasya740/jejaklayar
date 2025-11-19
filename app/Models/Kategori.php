<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model {
    use HasFactory;
    protected $table = 'kategori'; 
    protected $fillable = ['nama', 'slug', 'parent_id'];
    public $timestamps = false;

    public function parent() { return $this->belongsTo(Kategori::class, 'parent_id'); }
    public function children() { return $this->hasMany(Kategori::class, 'parent_id'); }
    public function artikels() { return $this->hasMany(Artikel::class); }
}