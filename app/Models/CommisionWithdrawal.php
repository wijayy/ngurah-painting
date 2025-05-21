<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommisionWithdrawal extends Model
{
    /** @use HasFactory<\Database\Factories\CommisionWithdrawalFactory> */
    use HasFactory;

    protected $guarded = ['id'];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public static function generateToken(): string
    {
        return substr(str_shuffle(str_repeat(
            '0123456789abcdefghijklmnopqrstuvwxyz',
            10
        )), 0, 10);
    }
}
