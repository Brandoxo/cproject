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
        Schema::create('external_panels', function (Blueprint $table) {
            $table->id();
            $table->string('panel_name');
            $table->string('api_url');
            $table->string('api_key');
            $table->string('panel_type');
            $table->enum('status', ['active', 'suspended', 'maintenance'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_panels');
    }
};
