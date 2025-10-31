<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'stiker';
    protected $primaryKey = 'id_stiker';
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id_driver');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaction::class, 'stiker_id', 'id_stiker');
    }

    public function kunjungan(): HasOne
    {
        return $this->hasOne(Kunjungan::class, 'stiker_id', 'id_stiker');
    }

    public $casts = [
        'tanggal_waktu' => 'datetime',
        'expired_at' => 'datetime',
        'used_at' => 'datetime',
    ];
}
