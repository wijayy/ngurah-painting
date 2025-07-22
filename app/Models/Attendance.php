<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function transaksi() {
        return $this->hasOne(Transaction::class, 'stiker_id', 'id_stiker');
    }
}
