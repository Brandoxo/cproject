<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrmCustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'full_name'        => $this->full_name,
            'email'            => $this->email,
            'whatsapp_number'  => $this->whatsapp_number,
            'notes'            => $this->notes,
            'service_lines'    => ServiceLineResource::collection($this->whenLoaded('serviceLines')),
            'created_at'       => $this->created_at->toIso8601String(),
            'updated_at'       => $this->updated_at->toIso8601String(),
        ];
    }
}
