<?php

use App\Models\Komisi;
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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id("id_pembayaran");
            $table->foreignIdFor(Komisi::class, 'komisi_id');
            $table->integer('amount');
            $table->enum('metode', ['cash', 'transfer']);
            $table->string('bukti_transfer_url');
            $table->string('bank')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nomor_referensi')->nullable();
            $table->string('catatan')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
