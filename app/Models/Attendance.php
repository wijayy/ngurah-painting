<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

        protected $guarded = ['id'];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
