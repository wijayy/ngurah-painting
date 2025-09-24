<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktifitas extends Model
{
    /** @use HasFactory<\Database\Factories\AktifitasFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aktifitas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
