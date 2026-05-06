<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogPackage extends Model
{
    protected $fillable = [
        'external_panel_id',
        'external_package_id',
        'name',
        'price_credits',
        'duration_value',
        'duration_unit',
        'is_active',
    ];

    protected $casts = [
        'price_credits' => 'decimal:2',
        'is_active'     => 'boolean',
    ];

    public function panel()
    {
        return $this->belongsTo(ExternalPanel::class, 'external_panel_id');
    }

    public function serviceLines()
    {
        return $this->hasMany(ServiceLine::class);
    }
}
