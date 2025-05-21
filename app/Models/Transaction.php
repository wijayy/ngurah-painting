<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, SoftDeletes, Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'transaction_number',
                'onUpdate' => true
            ]
        ];
    }

    protected $guarded = ['id'];
    // protected $with = ['transactionDetail'];

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    public static function transactionNumberGenerator()
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = 'TRX' . $date;

        // Hitung jumlah transaksi yang sudah ada hari ini
        $lastTransaction = self::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->transaction_number, -4);
            $nextNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . '-' . $formattedNumber;
    }
}
