<?php

namespace App\Models;

use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Str;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
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
                'source' => 'user_name',
                'onUpdate' => true
            ]
        ];
    }

    protected $guarded = ['id'];

    protected $primaryKey = 'id_driver';

    protected $with = ['attendance', 'komisi'];

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'driver_id', 'id_driver');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function komisi()
    {
        return $this->hasMany(Komisi::class, 'driver_id', 'id_driver');
    }
    public function tukar_poin()
    {
        return $this->hasMany(PenukaranPoin::class, 'driver_id', 'id_driver');
    }

    public function transaksi()
    {
        return $this->hasManyThrough(
            Transaction::class,   // Model akhir (tujuan)
            Attendance::class,      // Model perantara
            'driver_id',        // Foreign key di tabel `stiker` yang mengarah ke `driver`
            'stiker_id',        // Foreign key di tabel `transaksi` yang mengarah ke `stiker`
            'id_driver',        // Primary key di tabel `driver`
            'id_stiker'         // Primary key di tabel `stiker`
        );
    }

    public static function generateToken(): string
    {
        return substr(str_shuffle(str_repeat(
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            10
        )), 0, 30);
    }

    public static function memberNumberGenerator()
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = 'MBR-';

        // Hitung jumlah transaksi yang sudah ada hari ini
        $lastTransaction = self::orderBy('id_driver', 'desc')
            ->first();

        $nextNumber = 1;

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->membership_no, -4);
            $nextNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedNumber;
    }

        protected function casts(): array
    {
        return [
            'sim_berlaku_hingga' => 'datetime',
            // 'password' => 'hashed',
        ];
    }
}
