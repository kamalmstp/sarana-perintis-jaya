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
        Schema::table('order_proses', function (Blueprint $table) {
            $table->foreignId('location_dtp_id')->nullable()->constrained('locations')->after('delivery_location_id');
            $table->foreignId('location_ptp_id')->nullable()->constrained('locations')->after('location_dtp_id');
            $table->foreignId('location_ptd_id')->nullable()->constrained('locations')->after('location_ptp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_proses', function (Blueprint $table) {
            $table->dropForeign(['location_dtp_id']);
            $table->dropColumn('location_dtp_id');
            $table->dropForeign(['location_ptp_id']);
            $table->dropColumn('location_ptp_id');
            $table->dropForeign(['location_ptd_id']);
            $table->dropColumn('location_ptd_id');
        });
    }
};
