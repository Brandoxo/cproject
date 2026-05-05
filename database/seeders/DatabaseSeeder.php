<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $now = Carbon::now();

        // Desactivar restricciones de claves foráneas para limpiar e insertar sin problemas
        Schema::disableForeignKeyConstraints();

        // Limpiar tablas (Opcional, pero recomendado para evitar duplicados al correr --seed varias veces)
        $tables = [
            'roles', 'permissions', 'model_has_roles', 'role_has_permissions',
            'users', 'external_panels', 'external_accounts', 'crm_customers',
            'catalog_packages', 'catalog_bouquets', 'service_lines', 'notification_logs',
            'service_lines_bouquets', 'payments', 'credit_transactions_ledger'
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // ==========================================
        // 1. ROLES Y PERMISOS (SPATIE PATTERN)
        // ==========================================
        $roles = [
            ['id' => 1, 'name' => 'admin', 'guard_name' => 'web'],
            ['id' => 2, 'name' => 'reseller', 'guard_name' => 'web'],
        ];
        DB::table('roles')->insert($roles);

        $permissions = [
            ['id' => 1, 'name' => 'manage_panels', 'guard_name' => 'web'],
            ['id' => 2, 'name' => 'manage_users', 'guard_name' => 'web'],
            ['id' => 3, 'name' => 'create_lines', 'guard_name' => 'web'],
        ];
        DB::table('permissions')->insert($permissions);

        // Asignar todos los permisos al admin (Role 1)
        foreach ($permissions as $perm) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $perm['id'],
                'role_id' => 1
            ]);
        }
        // Asignar permiso de crear líneas al reseller (Role 2)
        DB::table('role_has_permissions')->insert(['permission_id' => 3, 'role_id' => 2]);

        // ==========================================
        // 2. CMS USERS
        // ==========================================
        $users = [
            [
                'id' => 1,
                'username' => 'superadmin',
                'name' => 'Super Admin',
                'email' => 'admin@iptvcms.com',
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'username' => 'reseller_juan',
                'name' => 'Juan Admin',
                'email' => 'admin2@iptvcms.com',
                'password' => Hash::make('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];
        DB::table('users')->insert($users);

        // Asignar roles a usuarios
        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_type' => 'App\\Models\\User', 'model_id' => 1],
            ['role_id' => 2, 'model_type' => 'App\\Models\\User', 'model_id' => 2],
        ]);

        // ==========================================
        // 3. EXTERNAL PANELS
        // ==========================================
        DB::table('external_panels')->insert([
            [
                'id' => 1,
                'panel_name' => 'Xtream Server USA',
                'api_url' => 'http://us1.xtream-panel.com/api.php',
                'api_key' => $faker->md5,
                'panel_type' => 'xtream_codes',
                'status' => 'active',
            ],
            [
                'id' => 2,
                'panel_name' => 'XUI Server EU',
                'api_url' => 'http://eu1.xui-panel.com/api',
                'api_key' => $faker->md5,
                'panel_type' => 'xui',
                'status' => 'active',
            ]
        ]);

        // ==========================================
        // 4. EXTERNAL ACCOUNTS
        // ==========================================
        DB::table('external_accounts')->insert([
            [
                'id' => 1,
                'external_panel_id' => 1,
                'external_user_id' => '1045',
                'user_id' => 2, // Vinculado a reseller_juan
                'cached_username' => 'juan_xtream',
                'cached_ip_address' => $faker->ipv4,
                'cached_status' => 'active',
                'credit_balance' => 500.00,
                'last_synced_at' => $now,
            ]
        ]);

        // ==========================================
        // 5. CRM CUSTOMERS
        // ==========================================
        $customers = [];
        for ($i = 1; $i <= 5; $i++) {
            $customers[] = [
                'id' => $i,
                'user_id' => 2, // Traídos por el reseller
                'full_name' => $faker->name,
                'whatsapp_number' => $faker->unique()->e164PhoneNumber,
                'email' => $faker->unique()->safeEmail,
                'notes' => $faker->sentence,
                'created_at' => $now,
                'deleted_at' => null,
            ];
        }
        DB::table('crm_customers')->insert($customers);

        // ==========================================
        // 6. CATALOG PACKAGES & BOUQUETS
        // ==========================================
        DB::table('catalog_packages')->insert([
            [
                'id' => 1, 'external_panel_id' => 1, 'external_package_id' => '2',
                'name' => '1 Mes VIP', 'price_credits' => 10.00,
                'duration_value' => 1, 'duration_unit' => 'months', 'is_active' => true
            ],
            [
                'id' => 2, 'external_panel_id' => 1, 'external_package_id' => '3',
                'name' => '3 Meses VIP', 'price_credits' => 25.00,
                'duration_value' => 3, 'duration_unit' => 'months', 'is_active' => true
            ],
        ]);

        DB::table('catalog_bouquets')->insert([
            ['id' => 1, 'external_panel_id' => 1, 'external_bouquet_id' => '1', 'name' => 'Deportes LATAM', 'is_active' => true],
            ['id' => 2, 'external_panel_id' => 1, 'external_bouquet_id' => '2', 'name' => 'Peliculas 4K', 'is_active' => true],
        ]);

        // ==========================================
        // 7. SERVICE LINES & RELATIONS
        // ==========================================
        $lines = [];
        for ($i = 1; $i <= 5; $i++) {
            $lines[] = [
                'id' => $i,
                'crm_customer_id' => $i,
                'external_panel_id' => 1,
                'external_account_id' => 1,
                'catalog_package_id' => 1,
                'cached_username' => $faker->userName . rand(100,999),
                'cached_password' => $faker->password(8, 12),
                'cached_status' => 'active',
                'cached_max_connections' => '1',
                'cached_expiration_date' => $now->copy()->addMonth(),
                'deleted_at' => null,
                'last_synced_at' => $now,
                'cached_is_trial' => false,
                'auto_renew' => false,
            ];
        }
        DB::table('service_lines')->insert($lines);

        // Asignar bouquets a las líneas
        foreach ($lines as $line) {
            DB::table('service_lines_bouquets')->insert([
                ['service_line_id' => $line['id'], 'catalog_bouquet_id' => 1],
                ['service_line_id' => $line['id'], 'catalog_bouquet_id' => 2],
            ]);
        }

        // ==========================================
        // 8. NOTIFICATION LOGS
        // ==========================================
        DB::table('notification_logs')->insert([
            [
                'id' => 1,
                'service_line_id' => 1,
                'notification_type' => 'nearby', 
                'sent_at' => $now,
                'status' => 'sent',
            ]
        ]);

        // ==========================================
        // 9. PAYMENTS & LEDGER
        // ==========================================
        DB::table('payments')->insert([
            [
                'id' => 1,
                'package_id' => 1, // Compra de saldo libre
                'catalog_package_name' => 'Saldo VIP', // Nombre genérico para compras de saldo
                'service_line_id' => null,
                'crm_customer_id' => 2,
                'amount_paid' => 500.00,
                'currency' => 'MXN',
                'payment_method' => 'Stripe',
                'image_path' => null,
                'transaction_id' => 'ch_' . $faker->md5,
                'status' => 'completed',
                'payment_date' => $now->copy()->subDays(2),
            ],
            [
                'id' => 2,
                'package_id' => 1,
                'catalog_package_name' => '1 Mes VIP',
                'service_line_id' => 1,
                'crm_customer_id' => 2,
                'amount_paid' => 10.00, // Lo que costó el paquete
                'currency' => 'MXN',
                'payment_method' => 'Balance', // Pagó con su saldo
                'image_path' => null,
                'transaction_id' => null,
                'status' => 'completed',
                'payment_date' => $now,
            ]
        ]);

        DB::table('credit_transactions_ledger')->insert([
            [
                'transaction_id' => 1,
                'external_account_id' => 1,
                'balance_after_transaction' => 500.00,
                'transaction_type' => 'credit_purchase',
                'payment_id' => 1,
                'service_line_id' => null,
                'admin_adjustment_reason' => null,
                'created_at' => $now->copy()->subDays(2),
            ],
            [
                'transaction_id' => 2,
                'external_account_id' => 1,
                'balance_after_transaction' => 490.00,
                'transaction_type' => 'line_creation_deduction',
                'payment_id' => 2,
                'service_line_id' => 1,
                'admin_adjustment_reason' => null,
                'created_at' => $now,
            ]
        ]);

        // Reactivar restricciones de claves foráneas
        Schema::enableForeignKeyConstraints();
    }
}