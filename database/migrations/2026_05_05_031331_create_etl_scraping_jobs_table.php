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
        Schema::create('etl_scraping_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_panel_id')->constrained()->onDelete('cascade');
            $table->foreignId('external_account_id')->constrained()->onDelete('cascade');
            $table->enum('job_type', ['api_sync', 'scrape_balance', 'scrape_lines', 'network_sniff'])->index();
            $table->string('target')->nullable();
            $table->enum('status', ['pending', 'running', 'success', 'failed'])->default('pending');
            $table->json('raw_payload')->nullable();
            $table->json('clean_payload')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etl_scraping_jobs');
    }
};
