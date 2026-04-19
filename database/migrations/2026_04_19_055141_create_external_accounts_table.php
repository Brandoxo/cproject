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
        Schema::create('external_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_panel_id')->constrained()->onDelete('cascade');
            $table->bigInteger('external_user_id')->unsigned();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cached_username')->nullable();
            $table->string('cached_ip_address')->nullable();
            $table->enum('cached_status', ['active', 'disabled'])->default('active');
            $table->decimal('credit_balance', 10, 2)->default(0);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_accounts');
    }
};
