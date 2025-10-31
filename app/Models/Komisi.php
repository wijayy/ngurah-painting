<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    /** @use HasFactory<\Database\Factories\KomisiFactory> */
    use HasFactory, Sluggable;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nomor_transaksi',
                'onUpdate' => true
            ]
        ];
    }

    public function getNomorTransaksiAttribute()
    {
        return $this->transaksi->nomor_transaksi;
    }

    protected $table = 'komisi';
    protected $guarded = ['id_komisi'];
    protected $primaryKey = 'id_komisi';

    public function transaksi()
    {
        return $this->belongsTo(Transaction::class, 'transaksi_id', 'id_transaksi');
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id_driver');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'komisi_id', 'id_komisi');
    }

    public function scopeSudahDicairkan($query)
    {
        return $query->whereHas('pembayaran');
    }

    public function scopeBelumDicairkan($query)
    {
        return $query->whereDoesntHave('pembayaran');
    }
}
