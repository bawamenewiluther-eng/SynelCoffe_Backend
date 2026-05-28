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

                // ======================
                // USER
                // ======================

                $table->string('customer_name');

                $table->string('customer_email');

                // ======================
                // PAYMENT
                // ======================

                $table->string('payment_method');

                $table->string('payment_status')
                    ->default('pending');

                $table->string('midtrans_order_id')
                    ->nullable();

                $table->string('transaction_id')
                    ->nullable();

                // ======================
                // PRICE
                // ======================

                $table->integer('total_price');

                // ======================
                // DATE
                // ======================

                $table->timestamp('paid_at')
                    ->nullable();

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
