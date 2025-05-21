<?php

use App\Models\Driver;
use App\Models\Region;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Region::class);
            $table->string('transaction_number')->unique();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('note')->nullable();
            $table->integer('total_amount');
            $table->integer('total_item');
            $table->integer('total_product');
            $table->integer('komisi')->default(0);
            $table->softDeletes();
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
