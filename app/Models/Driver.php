<?php

namespace App\Models;

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

    protected $with = ['attendance', 'commisionWithdrawal', 'transaction'];

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
    public function commisionWithdrawal()
    {
        return $this->hasMany(CommisionWithdrawal::class);
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateToken(): string
    {
        return substr(str_shuffle(str_repeat(
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            10
        )), 0, 30);
    }

    public static function generateQrFile($token)
    {
        $data = route('attendance.token', ['token' => $token]);
        $filename = 'qr/' . Str::uuid() . '.png';

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 6,
        ]);

        $imageData = (new QRCode($options))->render($data);

        // Simpan ke storage/app/public/qrcodes
        Storage::disk('public')->put($filename, $imageData);

       return $filename;
    }
}
