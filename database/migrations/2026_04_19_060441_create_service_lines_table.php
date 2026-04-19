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
        Schema::create('service_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_customer_id')->constrained()->onDelete('restrict');
            $table->foreignId('external_panel_id')->constrained()->onDelete('cascade');
            $table->foreignId('external_account_id')->constrained()->onDelete('cascade');
            $table->foreignId('catalog_package_id')->constrained()->onDelete('restrict');
            $table->string('cached_username')->nullable();
            $table->string('cached_password')->nullable();
            $table->enum('cached_status', ['active', 'disabled', 'expired'])->default('active');
            $table->string('cached_max_connections')->nullable();
            $table->dateTime('cached_expiration_date')->nullable();
            $table->boolean('cached_is_trial')->default(false);
            $table->softDeletes();
            $table->dateTime('last_synced_at')->nullable();
            $table->boolean('auto_renew')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_lines');
    }
};
