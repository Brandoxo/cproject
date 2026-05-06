<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalAccount extends Model
{
    protected $fillable = [
        'external_panel_id',
        'external_user_id',
        'user_id',
        'cached_username',
        'cached_password',
        'cached_ip_address',
        'cached_status',
        'credit_balance',
        'last_synced_at',
    ];

    protected $casts = [
        'cached_password' => 'encrypted',
        'credit_balance'  => 'decimal:2',
        'last_synced_at'  => 'datetime',
    ];

    public function panel()
    {
        return $this->belongsTo(ExternalPanel::class, 'external_panel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceLines()
    {
        return $this->hasMany(ServiceLine::class);
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransactionLedger::class);
    }

    public function etlScrapingJobs()
    {
        return $this->hasMany(EtlScrapingJob::class);
    }
}
