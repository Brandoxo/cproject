<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogPackageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'external_panel_id'   => $this->external_panel_id,
            'external_package_id' => $this->external_package_id,
            'name'                => $this->name,
            'price_credits'       => $this->price_credits,
            'duration_value'      => $this->duration_value,
            'duration_unit'       => $this->duration_unit,
            'is_active'           => $this->is_active,
            'created_at'          => $this->created_at->toIso8601String(),
            'updated_at'          => $this->updated_at->toIso8601String(),
        ];
    }
}
