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
        Schema::create('credit_transactions_ledger', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->foreignId('external_account_id')->constrained();
            $table->decimal('balance_after_transaction', 10, 2);
            $table->enum('transaction_type', ['credit_purchase', 'line_creation_deduction', 'admin_adjustment', 'refund_deduction', 'payment_reversal']);
            $table->bigInteger('payment_id')->nullable()->unsigned();
            $table->bigInteger('service_line_id')->nullable()->unsigned();
            $table->string('admin_adjustment_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_transactions_ledger');
    }
};
