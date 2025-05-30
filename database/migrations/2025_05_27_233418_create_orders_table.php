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
            $table->foreignId('customer_id')
            ->constrained('customers', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('spk_number');
            $table->date('spk_date');
            $table->enum('delivery_term', ['dtd','dtp','ptd','ptp']);
            $table->string('item')->nullable();
            $table->string('period')->nullable();
            $table->decimal('total_kg', 10, 2)->nullable();
            $table->integer('total_bag')->nullable();
            $table->foreignId('loading_location_id')->nullable()
            ->constrained('locations', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('note')->nullable();
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
