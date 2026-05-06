<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceLineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'crm_customer_id'         => $this->crm_customer_id,
            'external_panel_id'       => $this->external_panel_id,
            'external_account_id'     => $this->external_account_id,
            'catalog_package_id'      => $this->catalog_package_id,
            'external_line_id'        => $this->external_line_id,
            'cached_username'         => $this->cached_username,
            'cached_status'           => $this->cached_status,
            'cached_max_connections'  => $this->cached_max_connections,
            'cached_expiration_date'  => $this->cached_expiration_date?->toIso8601String(),
            'cached_is_trial'         => $this->cached_is_trial,
            'auto_renew'              => $this->auto_renew,
            'last_synced_at'          => $this->last_synced_at?->toIso8601String(),
            'customer'                => new CrmCustomerResource($this->whenLoaded('customer')),
            'package'                 => new CatalogPackageResource($this->whenLoaded('package')),
            'bouquets'                => CatalogBouquetResource::collection($this->whenLoaded('bouquets')),
            'created_at'              => $this->created_at->toIso8601String(),
            'updated_at'              => $this->updated_at->toIso8601String(),
        ];
    }
}
