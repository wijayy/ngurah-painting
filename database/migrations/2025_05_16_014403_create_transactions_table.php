<?php

use App\Models\Attendance;
use App\Models\Driver;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignIdFor(Attendance::class, 'stiker_id')->nullable();
            $table->string('nomor_transaksi')->unique();
            $table->string('slug')->unique();
            $table->enum('metode_pembayaran', ['cash', 'transfer']);
            $table->integer('total_harga');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
