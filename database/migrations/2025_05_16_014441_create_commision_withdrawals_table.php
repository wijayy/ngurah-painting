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
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Driver::class);
            $table->integer('amount');
            $table->string('image')->nullable();
            $table->string('token')->unique();
            $table->enum('withdrawal_method', ['cash', 'transfer']);
            $table->enum('status', ['requested', 'declined', 'accepted'])->default('requested');
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
