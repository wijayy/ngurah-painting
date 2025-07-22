<?php

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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('id_driver');
            $table->foreignIdFor(User::class);
            $table->string('bank')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('token');
            $table->string('no_ktp');
            $table->string('no_telepon');
            $table->string('foto_ktp');
            $table->boolean('status')->default(1);
            $table->integer('poin')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
