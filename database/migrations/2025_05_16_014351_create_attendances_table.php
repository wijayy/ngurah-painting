<?php

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stiker', function (Blueprint $table) {
            $table->id('id_stiker');
            $table->foreignIdFor(Driver::class, 'driver_id');
            $table->integer('nomor_stiker');
            $table->integer('jumlah_wisatawan');
            $table->dateTime('tanggal_waktu');
            $table->dateTime('expired_at');
            $table->dateTime('used_at')->nullable();
            $table->string('nama');
            $table->string('wa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
