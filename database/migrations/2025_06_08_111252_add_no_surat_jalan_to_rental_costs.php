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
        Schema::table('rental_costs', function (Blueprint $table) {
            $table->string('no_kwitansi')->nullable()->after('tarif_rental');
            $table->string('no_surat_jalan')->nullable()->after('no_kwitansi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_costs', function (Blueprint $table) {
            //
        });
    }
};
