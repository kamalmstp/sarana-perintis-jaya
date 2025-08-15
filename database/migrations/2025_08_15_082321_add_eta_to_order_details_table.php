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
            $table->date('eta')->nullable()->after('date_detail');
            $table->date('etd')->nullable()->after('eta');
            $table->date('date_muat')->nullable()->after('etd');
            $table->date('date_bongkar')->nullable()->after('date_muat');
            $table->decimal('kg_send',10,2)->nullable()->after('bag_received');
            $table->decimal('kg_received',10,2)->nullable()->after('kg_send');
            $table->string('bl')->nullable()->after('kg_received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn([
                'eta',
                'etd',
                'date_muat',
                'date_bongkar',
                'kg_send',
                'kg_received',
                'bl',
            ]);
        });
    }
};
