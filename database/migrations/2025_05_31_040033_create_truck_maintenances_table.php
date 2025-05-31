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
        Schema::create('truck_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('truck_id')->constraint('trucks', 'id');
            $table->date('date')->nullabel();
            $table->integer('qty')->nullabel();
            $table->bigInteger('price')->nullabel();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_maintenances');
    }
};
