<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EtlJobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'external_panel_id'   => $this->external_panel_id,
            'external_account_id' => $this->external_account_id,
            'job_type'            => $this->job_type,
            'target'              => $this->target,
            'status'              => $this->status,
            'clean_payload'       => $this->clean_payload,
            'error_message'       => $this->error_message,
            'attempts'            => $this->attempts,
            'started_at'          => $this->started_at?->toIso8601String(),
            'finished_at'         => $this->finished_at?->toIso8601String(),
            'created_at'          => $this->created_at->toIso8601String(),
        ];
    }
}
