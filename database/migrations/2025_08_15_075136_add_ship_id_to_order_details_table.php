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
            $table->foreignId('ship_id')->nullable()->constrained('ships')->onDelete('set null')->after('driver_id');
            $table->foreignId('shipping_line_id')->nullable()->constrained('shipping_lines')->onDelete('set null')->after('ship_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign(['ship_id']);
            $table->dropColumn('ship_id');
            $table->dropForeign(['shipping_line_id']);
            $table->dropColumn('shipping_line_id');
        });
    }
};
