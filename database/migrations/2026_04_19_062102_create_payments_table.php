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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->unsigned();
            $table->string('catalog_package_name');
            $table->foreignId('service_line_id')->nullable()->constrained()->onDelete('set null');
            $table->bigInteger('crm_customer_id')->unsigned();
            $table->decimal('amount_paid', 10, 2);
            $table->string('currency', 10);
            $table->string('payment_method')->nullable();
            $table->string('image_path')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['completed', 'pending', 'failed', 'refunded'])->default('pending');
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
