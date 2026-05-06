<?php

use App\Http\Controllers\Api\V1\AuditLogController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CatalogBouquetController;
use App\Http\Controllers\Api\V1\CatalogPackageController;
use App\Http\Controllers\Api\V1\CrmCustomerController;
use App\Http\Controllers\Api\V1\EtlJobController;
use App\Http\Controllers\Api\V1\ExternalAccountController;
use App\Http\Controllers\Api\V1\ExternalPanelController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\LedgerController;
use App\Http\Controllers\Api\V1\NotificationLogController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ServiceLineController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────
// Health (público — badge de frescura frontend)
// ──────────────────────────────────────────────
Route::prefix('v1/health')->group(function () {
    Route::get('/sync/{panel}', [HealthController::class, 'sync']);
});

// ──────────────────────────────────────────────
// Autenticación
// ──────────────────────────────────────────────
Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// ──────────────────────────────────────────────
// Rutas protegidas (auth:sanctum)
// ──────────────────────────────────────────────
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // ── Health del sistema ──
    Route::get('/health/system', [HealthController::class, 'system']);

    // ── Usuarios internos (ROOT) ──
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
        Route::patch('/{user}/toggle-active', [UserController::class, 'toggleActive']);
    });

    // ── CRM Clientes ──
    Route::prefix('crm/customers')->group(function () {
        Route::get('/', [CrmCustomerController::class, 'index']);
        Route::post('/', [CrmCustomerController::class, 'store']);
        Route::get('/{customer}', [CrmCustomerController::class, 'show']);
        Route::put('/{customer}', [CrmCustomerController::class, 'update']);
        Route::delete('/{customer}', [CrmCustomerController::class, 'destroy']);
    });

    // ── Paneles Externos (sub-recursos anidados) ──
    Route::prefix('panels')->group(function () {
        Route::get('/', [ExternalPanelController::class, 'index']);
        Route::post('/', [ExternalPanelController::class, 'store']);
        Route::get('/{panel}', [ExternalPanelController::class, 'show']);
        Route::put('/{panel}', [ExternalPanelController::class, 'update']);
        Route::delete('/{panel}', [ExternalPanelController::class, 'destroy']);
        Route::patch('/{panel}/status', [ExternalPanelController::class, 'changeStatus']);

        // Cuentas externas (wallets)
        Route::prefix('/{panel}/accounts')->group(function () {
            Route::get('/', [ExternalAccountController::class, 'index']);
            Route::post('/', [ExternalAccountController::class, 'store']);
            Route::get('/{account}', [ExternalAccountController::class, 'show']);
            Route::put('/{account}', [ExternalAccountController::class, 'update']);
            Route::delete('/{account}', [ExternalAccountController::class, 'destroy']);
            Route::post('/{account}/sync', [ExternalAccountController::class, 'sync']);
        });

        // Catálogo — Paquetes
        Route::prefix('/{panel}/packages')->group(function () {
            Route::get('/', [CatalogPackageController::class, 'index']);
            Route::post('/', [CatalogPackageController::class, 'store']);
            Route::post('/sync', [CatalogPackageController::class, 'sync']);
            Route::get('/{package}', [CatalogPackageController::class, 'show']);
            Route::put('/{package}', [CatalogPackageController::class, 'update']);
            Route::delete('/{package}', [CatalogPackageController::class, 'destroy']);
        });

        // Catálogo — Bouquets
        Route::prefix('/{panel}/bouquets')->group(function () {
            Route::get('/', [CatalogBouquetController::class, 'index']);
            Route::post('/', [CatalogBouquetController::class, 'store']);
            Route::post('/sync', [CatalogBouquetController::class, 'sync']);
            Route::get('/{bouquet}', [CatalogBouquetController::class, 'show']);
            Route::put('/{bouquet}', [CatalogBouquetController::class, 'update']);
            Route::delete('/{bouquet}', [CatalogBouquetController::class, 'destroy']);
        });
    });

    // ── Líneas de Servicio (core del dominio) ──
    Route::prefix('lines')->group(function () {
        Route::get('/', [ServiceLineController::class, 'index']);
        Route::post('/', [ServiceLineController::class, 'store']);
        Route::get('/expiring', [ServiceLineController::class, 'expiring']);
        Route::get('/{line}', [ServiceLineController::class, 'show']);
        Route::put('/{line}', [ServiceLineController::class, 'update']);
        Route::delete('/{line}', [ServiceLineController::class, 'destroy']);
        Route::get('/{line}/password', [ServiceLineController::class, 'password']);
        Route::post('/{line}/sync', [ServiceLineController::class, 'sync']);
    });

    // ── Pagos (ROOT únicamente — validado en FormRequest) ──
    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::post('/', [PaymentController::class, 'store']);
        Route::get('/{payment}', [PaymentController::class, 'show']);
        Route::patch('/{payment}/status', [PaymentController::class, 'updateStatus']);
        Route::get('/{payment}/receipt', [PaymentController::class, 'receipt']);
    });

    // ── Libro Contable (append-only, ROOT) ──
    Route::prefix('ledger')->group(function () {
        Route::get('/', [LedgerController::class, 'index']);
        Route::get('/{ledger}', [LedgerController::class, 'show']);
        Route::post('/adjustments', [LedgerController::class, 'adjustment']);
    });

    // ── Logs de Notificaciones ──
    Route::prefix('notification-logs')->group(function () {
        Route::get('/', [NotificationLogController::class, 'index']);
        Route::get('/{notificationLog}', [NotificationLogController::class, 'show']);
    });

    // ── ETL Jobs ──
    Route::prefix('etl/jobs')->group(function () {
        Route::get('/', [EtlJobController::class, 'index']);
        Route::post('/', [EtlJobController::class, 'store']);
        Route::get('/{etlJob}', [EtlJobController::class, 'show']);
        Route::post('/{etlJob}/retry', [EtlJobController::class, 'retry']);
        Route::delete('/{etlJob}/cancel', [EtlJobController::class, 'cancel']);
    });

    // ── Auditoría (ROOT únicamente) ──
    Route::prefix('audit-logs')->group(function () {
        Route::get('/', [AuditLogController::class, 'index']);
        Route::get('/{auditLog}', [AuditLogController::class, 'show']);
    });
});
