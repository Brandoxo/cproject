<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceLine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'crm_customer_id',
        'external_panel_id',
        'external_account_id',
        'catalog_package_id',
        'external_line_id',
        'cached_username',
        'cached_password',
        'cached_status',
        'cached_max_connections',
        'cached_expiration_date',
        'cached_is_trial',
        'auto_renew',
        'last_synced_at',
    ];

    protected $casts = [
        'cached_is_trial'        => 'boolean',
        'auto_renew'             => 'boolean',
        'cached_expiration_date' => 'datetime',
        'last_synced_at'         => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(CrmCustomer::class, 'crm_customer_id');
    }

    public function panel()
    {
        return $this->belongsTo(ExternalPanel::class, 'external_panel_id');
    }

    public function account()
    {
        return $this->belongsTo(ExternalAccount::class, 'external_account_id');
    }

    public function package()
    {
        return $this->belongsTo(CatalogPackage::class, 'catalog_package_id');
    }

    public function bouquets()
    {
        return $this->belongsToMany(CatalogBouquet::class, 'service_lines_bouquets');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }
}
