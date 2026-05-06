<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'service_line_id'   => $this->service_line_id,
            'crm_customer_id'   => $this->crm_customer_id,
            'channel'           => $this->channel,
            'notification_type' => $this->notification_type,
            'status'            => $this->status,
            'payload'           => $this->payload,
            'sent_at'           => $this->sent_at?->toIso8601String(),
            'error_message'     => $this->error_message,
            'created_at'        => $this->created_at->toIso8601String(),
        ];
    }
}
