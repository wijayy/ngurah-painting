<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kunjungan extends Model
{
    /** @use HasFactory<\Database\Factories\KunjunganFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    // protected $table = 'kunjungans';
    protected $primaryKey = 'id_kunjungan';

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class, 'stiker_id', 'id_stiker');
    }
}
