<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    /** @use HasFactory<\Database\Factories\PembayaranFactory> */
    use HasFactory;

    protected $table = 'pembayaran';
    protected $guarded = ['id_pembayaran'];
    protected $primaryKey = 'id_pembayaran';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['waktu_pembayaran' => 'datetime'];

    public function komisi()
    {
        return $this->belongsTo(Komisi::class, 'komisi_id', 'id_komisi');
    }


}
