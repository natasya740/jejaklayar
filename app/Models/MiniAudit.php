<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiniAudit extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'meta',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
