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
        Schema::create('commision_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class);
            $table->integer('poin');
            $table->string('image')->nullable();
            $table->string('token')->unique();
            $table->enum('metode_penukaran', ['cash', 'transfer']);
            $table->enum('status', ['diajukan', 'ditolak', 'diterima'])->default(value: 'diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commision_withdrawals');
    }
};
