<?php
// database/migrations/2026_05_04_000001_harden_schema_v1.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. external_panels — cifrado + soft delete
        Schema::table('external_panels', function (Blueprint $t) {
            $t->text('api_key')->change();
        });

        // 2. external_accounts — password, unique, status, índice
        Schema::table('external_accounts', function (Blueprint $t) {
            $t->text('cached_password')->nullable()->after('cached_username');
            $t->index('last_synced_at');
            $t->unique(['external_panel_id', 'external_user_id'], 'ext_acc_panel_user_uq');
        });
        DB::statement("ALTER TABLE external_accounts MODIFY cached_status 
                       ENUM('active','disabled','suspended') NOT NULL DEFAULT 'active'");

        // 3. crm_customers — índices + uniques + tipo notes
        Schema::table('crm_customers', function (Blueprint $t) {
            $t->text('notes')->nullable()->change();
            $t->index('email');
            $t->index('whatsapp_number');
            $t->unique(['user_id', 'email'],            'crm_user_email_uq');
            $t->unique(['user_id', 'whatsapp_number'],  'crm_user_whatsapp_uq');
        });

        // 4. service_lines — encrypted password, índices, external_line_id
        Schema::table('service_lines', function (Blueprint $t) {
            $t->text('cached_password')->nullable()->change();
            $t->unsignedBigInteger('external_line_id')->nullable()->after('catalog_package_id');
            $t->unsignedTinyInteger('cached_max_connections')->nullable()->change();
            $t->index('cached_expiration_date');
            $t->index('cached_status');
            $t->index('auto_renew');
            $t->unique(['external_panel_id', 'external_line_id'], 'svc_panel_line_uq');
        });

        // 5. payments — FKs faltantes + índices + tipo currency
       Schema::table('payments', function (Blueprint $t) {
    // 1. Hacer la columna nullable PRIMERO
    $t->unsignedBigInteger('package_id')->nullable()->change();

    $t->char('currency', 3)->change();

    // 2. Ahora sí: FK con nullOnDelete (snapshot soft)
    $t->foreign('package_id')
      ->references('id')->on('catalog_packages')
      ->nullOnDelete();

    // Cliente: integridad estricta
    $t->foreign('crm_customer_id')
      ->references('id')->on('crm_customers')
      ->restrictOnDelete();

    // Snapshots del cliente
    $t->string('customer_full_name_snapshot')->nullable()->after('crm_customer_id');
    $t->string('customer_email_snapshot')->nullable()->after('customer_full_name_snapshot');
    $t->string('customer_whatsapp_snapshot')->nullable()->after('customer_email_snapshot');

    // Auditoría
    $t->foreignId('user_id')->nullable()->after('crm_customer_id')
      ->constrained('users')->nullOnDelete();

    // Índices
    $t->index('status');
    $t->index('payment_date');
    $t->index('crm_customer_id');
});

        // 6. credit_transactions_ledger — append-only + FKs + unique
        Schema::table('credit_transactions_ledger', function (Blueprint $t) {
            $t->dropColumn('updated_at');
            $t->unique('transaction_id');
            $t->foreign('payment_id')->references('id')->on('payments')->nullOnDelete();
            $t->foreign('service_line_id')->references('id')->on('service_lines')->nullOnDelete();
            $t->index(['transaction_type', 'created_at']);
        });

        // 7. notification_logs — multi-canal real
        Schema::table('notification_logs', function (Blueprint $t) {
            $t->enum('channel', ['email', 'sms', 'whatsapp'])
              ->default('email')->after('service_line_id');
            $t->foreignId('crm_customer_id')->nullable()->after('channel')
              ->constrained('crm_customers')->cascadeOnDelete();
            $t->json('payload')->nullable()->after('status');
            $t->index('notification_type');
            $t->index('sent_at');
        });

        // 8. etl_scraping_jobs — corrección del modelo
        Schema::table('etl_scraping_jobs', function (Blueprint $t) {
            $t->unsignedBigInteger('external_account_id')->nullable()->change();
            $t->json('raw_payload')->nullable()->change();
            $t->json('clean_payload')->nullable()->change();
            $t->unsignedTinyInteger('attempts')->default(0)->after('finished_at');
            $t->index('status');
        });
        DB::statement("ALTER TABLE etl_scraping_jobs MODIFY job_type 
                       ENUM('api_sync','scrape_balance','scrape_lines','network_sniff') NOT NULL");

        // 9. catalog_packages / bouquets — uniques de sync
        Schema::table('catalog_packages', function (Blueprint $t) {
            $t->unsignedBigInteger('external_package_id')->change();
            $t->unique(['external_panel_id', 'external_package_id'], 'cat_pkg_panel_ref_uq');
            $t->index('is_active');
        });
        Schema::table('catalog_bouquets', function (Blueprint $t) {
            $t->unique(['external_panel_id', 'external_bouquet_id'], 'cat_bq_panel_ref_uq');
            $t->index('is_active');
        });

        // 10. users — limpieza Jetstream + flags
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['current_team_id', 'profile_photo_path']);
            $t->boolean('is_active')->default(true)->after('password');
            $t->timestamp('last_login_at')->nullable()->after('is_active');
            $t->softDeletes();
        });

        // 11. audit_logs — trazabilidad ROOT/ADMIN
        Schema::create('audit_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->morphs('auditable');
            $t->string('event', 32);
            $t->json('old_values')->nullable();
            $t->json('new_values')->nullable();
            $t->string('ip_address', 45)->nullable();
            $t->string('user_agent', 255)->nullable();
            $t->timestamp('created_at')->useCurrent();
            $t->index(['event', 'created_at']);
        });
    }

    public function down(): void
    {
        // Rollback granular omitido por brevedad — implementar antes de prod.
    }
};