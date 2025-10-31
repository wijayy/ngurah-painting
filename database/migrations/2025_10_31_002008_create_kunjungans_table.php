<?php

use App\Models\Attendance;
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
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id('id_kunjungan');
            $table->foreignIdFor(Attendance::class, 'stiker_id')->constrained();
            $table->integer('jumlah_wisatawan');
            $table->dateTime('tanggal_waktu');
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
        Schema::dropIfExists('kunjungans');
    }
};
