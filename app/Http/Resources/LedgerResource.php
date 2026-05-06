<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LedgerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'transaction_id'            => $this->transaction_id,
            'external_account_id'       => $this->external_account_id,
            'transaction_type'          => $this->transaction_type,
            'balance_after_transaction' => $this->balance_after_transaction,
            'payment_id'                => $this->payment_id,
            'service_line_id'           => $this->service_line_id,
            'admin_adjustment_reason'   => $this->admin_adjustment_reason,
            'created_at'                => $this->created_at->toIso8601String(),
        ];
    }
}
