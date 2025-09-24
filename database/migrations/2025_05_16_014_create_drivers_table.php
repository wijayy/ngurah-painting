<?php

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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('id_driver');
            $table->foreignIdFor(User::class);
            $table->string('membership_no');
            $table->string('bank')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('token');
            $table->string('no_ktp');
            $table->string('no_sim');
            $table->string('no_telepon');
            $table->string('url_foto_ktp');
            $table->string('url_foto_sim');
            $table->string(column: 'alamat')->nullable();
            $table->dateTime('sim_berlaku_hingga');
            $table->string('status')->default("aktif");
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
