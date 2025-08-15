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
        Schema::create('order_proses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
            ->constrained('orders', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('do_number')->nullable();
            $table->string('po_number')->nullable();
            $table->string('so_number')->nullable();
            
            $table->string('item_proses')->nullable();
            $table->decimal('total_kg_proses', 10, 2)->nullable();
            $table->integer('total_bag_proses')->nullable();
            $table->foreignId('delivery_location_id')->nullable()
            ->constrained('locations', 'id')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('type_proses',['gudang','kapal','container']);
            $table->string('tally_proses')->nullable();
            $table->decimal('tarif', 12, 2)->nullable();
            
            $table->enum('operation_proses', ['bongkar','teruskan'])->nullable();
            $table->integer('total_container_proses')->nullable();
            $table->string('no_container_proses')->nullable();
            $table->string('lock_number_proses')->nullable();
            $table->string('vessel_name_proses')->nullable();
            $table->string('warehouse_proses')->nullable();
            $table->enum('invoice_status', ['none','pending','sent','paid','canceled'])->nullable();
            $table->text('note_proses')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_proses');
    }
};
