<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poin extends Model
{
    /** @use HasFactory<\Database\Factories\PoinFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    // protected $table = 'poins';
    protected $primaryKey = 'id_poin';

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id_driver');
    }
}
