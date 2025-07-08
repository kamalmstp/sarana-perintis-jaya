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
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('container_number')->nullable()->after('note_detail');
            $table->string('seal_number')->nullable()->after('container_number');
            $table->string('lock_number')->nullable()->after('seal_number');
            $table->string('vessel_name')->nullable()->after('lock_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn([
                'container_number',
                'seal_number',
                'lock_number',
                'vessel_name'
            ]);
        });
    }
};
