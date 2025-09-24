<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenukaranPoin extends Model
{
    /** @use HasFactory<\Database\Factories\PenukaranPoinFactory> */
    use HasFactory;

    protected $table = 'penukaran_poin';
    protected $guarded = ['id_penukaran'];
    protected $primaryKey = 'id_penukaran';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'disetujui_at' => 'datetime',
        'ditolak_at' => 'datetime',
    ];

    /**
     * Get the casts array for the model.
     *
     * @return array
     */
    public function casts()
    {
        return $this->casts;
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id_driver');
    }

    public static function generateToken(): string
    {
        return substr(str_shuffle(str_repeat(
            '0123456789abcdefghijklmnopqrstuvwxyz',
            10
        )), 0, 10);
    }

}
