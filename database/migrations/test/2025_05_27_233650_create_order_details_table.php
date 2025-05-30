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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_proses_id')
            ->constrained('order_proses', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('truck_id')
            ->constrained('trucks', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date_detail');
            $table->integer('bag_send')->nullable();
            $table->integer('bag_received')->nullable();
            $table->decimal('bruto',10,2)->nullable();
            $table->decimal('tara',10,2)->nullable();
            $table->decimal('netto',10,2)->nullable();
            $table->enum('status_detail', ['pending', 'proses', 'selesai'])->nullable();
            $table->text('note_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
