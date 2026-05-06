<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'external_panel_id' => $this->external_panel_id,
            'external_user_id'  => $this->external_user_id,
            'user_id'           => $this->user_id,
            'cached_username'   => $this->cached_username,
            'cached_ip_address' => $this->cached_ip_address,
            'cached_status'     => $this->cached_status,
            'credit_balance'    => $this->credit_balance,
            'last_synced_at'    => $this->last_synced_at?->toIso8601String(),
            'created_at'        => $this->created_at->toIso8601String(),
            'updated_at'        => $this->updated_at->toIso8601String(),
        ];
    }
}
