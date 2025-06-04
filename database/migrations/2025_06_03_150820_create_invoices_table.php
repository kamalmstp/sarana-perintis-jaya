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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders','id')->cascadeOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue'])->default('draft');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
