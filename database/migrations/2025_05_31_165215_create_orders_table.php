<?php

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->nullable()->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->dateTime('order_date');
            $table->date('rental_start');
            $table->date('rental_end');
            $table->enum('status', ['pending', 'confirmed', 'ongoing', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed', 'expired', 'refunded'])->default('unpaid');
            $table->string('snap_token')->nullable();
            $table->json('payment_response')->nullable();
            $table->text('address');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
