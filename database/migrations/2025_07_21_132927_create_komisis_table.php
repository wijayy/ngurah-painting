<?php

use App\Models\Driver;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('komisi', function (Blueprint $table) {
            $table->id('id_komisi');
            $table->foreignIdFor(Transaction::class, 'transaksi_id');
            $table->foreignIdFor(Driver::class, 'driver_id');
            $table->integer('komisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komisis');
    }
};
