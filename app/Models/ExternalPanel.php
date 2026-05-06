<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalPanel extends Model
{
    protected $fillable = [
        'panel_name',
        'api_url',
        'api_key',
        'panel_type',
        'status',
    ];

    protected $casts = [
        'api_key' => 'encrypted',
    ];

    public function externalAccounts()
    {
        return $this->hasMany(ExternalAccount::class);
    }

    public function catalogPackages()
    {
        return $this->hasMany(CatalogPackage::class);
    }

    public function catalogBouquets()
    {
        return $this->hasMany(CatalogBouquet::class);
    }

    public function serviceLines()
    {
        return $this->hasMany(ServiceLine::class);
    }

    public function etlScrapingJobs()
    {
        return $this->hasMany(EtlScrapingJob::class);
    }
}
