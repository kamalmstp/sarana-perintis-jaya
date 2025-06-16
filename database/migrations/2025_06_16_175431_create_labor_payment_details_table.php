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
        Schema::create('labor_payment_details', function (Blueprint $table) {
            // migration labor_payment_details
            $table->id();
            $table->foreignId('labor_payment_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_proses_id')->constrained()->nullable();
            $table->decimal('qty_kg')->nullable();
            $table->decimal('tarif_per_kg')->nullable();
            $table->decimal('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_payment_details');
    }
};
