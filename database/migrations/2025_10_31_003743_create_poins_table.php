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
        Schema::create('poins', function (Blueprint $table) {
            $table->id('id_poin');
            $table->foreignIdFor(Driver::class, 'driver_id')->constrained();
            $table->integer('poin');
            $table->enum('status', ['penambahan', 'penukaran', 'permintaan', 'penolakan'])->default('penambahan');
            $table->text('pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poins');
    }
};
