<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionDetailFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'transaksi_item';
    protected $primaryKey = 'id_item';
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaksi_id', 'id_transaksi');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id_produk');
    }
}
