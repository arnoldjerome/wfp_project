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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();
            $table->enum('status', ['pending', 'preparing', 'completed', 'cancelled'])->default('pending');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('payment_method_id')->constrained('payments')->onDelete('restrict');
            $table->enum('payment_status', ['waiting', 'paid', 'failed'])->default('waiting');
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->nullOnDelete();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_price', 10, 2);
            $table->timestamp('ordered_at')->nullable();
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
