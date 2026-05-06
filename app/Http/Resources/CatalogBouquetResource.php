<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogBouquetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'external_panel_id'    => $this->external_panel_id,
            'external_bouquet_id'  => $this->external_bouquet_id,
            'name'                 => $this->name,
            'is_active'            => $this->is_active,
            'created_at'           => $this->created_at->toIso8601String(),
            'updated_at'           => $this->updated_at->toIso8601String(),
        ];
    }
}
