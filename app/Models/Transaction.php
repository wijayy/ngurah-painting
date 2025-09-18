<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Contracts\Database\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
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

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $guarded = ['id_transaksi'];
    // protected $with = ['transactionDetail'];

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transaksi_id', 'id_transaksi');
    }

    public function stiker()
    {
        return $this->belongsTo(Attendance::class, 'stiker_id', 'id_stiker');
    }

    public function komisi()
    {
        return $this->hasOne(Komisi::class, 'transaksi_id', 'id_transaksi');
    }

    public static function transactionNumberGenerator()
    {
        $date = Carbon::now()->format('Y');
        $prefix = 'TRX-' . $date . '-';

        // Hitung jumlah transaksi yang sudah ada hari ini
        $lastTransaction = self::orderBy('id_transaksi', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->nomor_transaksi, -4);
            $nextNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }

    public function scopeFilters(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nomor_transaksi', 'like', '%' . $search . '%')
                    ->orWhereHas('stiker', function (Builder $query) use ($search) {
                        $query->where('nomor_stiker', 'like', '%' . $search . '%')
                        ;
                    });

            });
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            if ($status !== '') {
                $query->where('status', $status);
            }
        });
    }
}
