<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogBouquet extends Model
{
    protected $fillable = [
        'external_panel_id',
        'external_bouquet_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function panel()
    {
        return $this->belongsTo(ExternalPanel::class, 'external_panel_id');
    }

    public function serviceLines()
    {
        return $this->belongsToMany(ServiceLine::class, 'service_lines_bouquets');
    }
}
