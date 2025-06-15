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
        Schema::create('rental_payment_rental_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_payment_id')
            ->constrained('rental_payments', 'id')->cascadeOnDelete();
            $table->foreignId('rental_cost_id')
            ->constrained('rental_costs', 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_payment_rental_costs');
    }
};
