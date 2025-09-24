<?php

use App\Models\Driver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penukaran_poin', function (Blueprint $table) {
            $table->id('id_penukaran');
            $table->foreignIdFor(Driver::class, 'driver_id');
            $table->integer('poin');
            $table->integer('jumlah');
            $table->string('bukti_url')->nullable();
            $table->string('token');
            $table->enum('metode_penukaran', ['cash', 'transfer'])->nullable();
            $table->string('bank')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->enum('status', ['diajukan', 'ditolak', 'disetujui'])->default('diajukan');
            $table->timestamp('disetujui_at')->nullable();
            $table->timestamp('ditolak_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penukaran_poins');
    }
};
