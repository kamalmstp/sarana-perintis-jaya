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
        Schema::create('driver_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_detail_id')->constraint('order_details', 'id')->nullable();
            $table->decimal('uang_sangu', 15,2)->nullable();
            $table->decimal('uang_jalan', 15,2)->nullable();
            $table->decimal('uang_bbm', 15,2)->nullable();
            $table->decimal('uang_kembali', 15,2)->nullable();
            $table->decimal('gaji_driver', 15,2)->nullable();
            $table->string('status')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_costs');
    }
};
