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
        Schema::create('rental_costs_rental_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rental_costs_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_costs_rental_payment');
    }
};
