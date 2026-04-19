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
        Schema::create('service_lines_bouquets', function (Blueprint $table) {
            $table->foreignId('service_line_id')->constrained()->onDelete('cascade');
            $table->foreignId('catalog_bouquet_id')->constrained()->onDelete('cascade');

            $table->primary(['service_line_id', 'catalog_bouquet_id'], 'service_line_bouquet_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_lines_bouquets');
    }
};
