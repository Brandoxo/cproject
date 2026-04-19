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
        Schema::create('catalog_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_panel_id')->constrained()->onDelete('cascade');
            $table->integer('external_package_id');
            $table->string('name');
            $table->decimal('price_credits', 10, 2);
            $table->integer('duration_value');
            $table->enum('duration_unit', ['hours', 'days', 'months', 'years']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_packages');
    }
};
