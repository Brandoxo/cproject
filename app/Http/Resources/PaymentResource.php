<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                           => $this->id,
            'crm_customer_id'              => $this->crm_customer_id,
            'service_line_id'              => $this->service_line_id,
            'package_id'                   => $this->package_id,
            'catalog_package_name'         => $this->catalog_package_name,
            'customer_full_name_snapshot'  => $this->customer_full_name_snapshot,
            'customer_email_snapshot'      => $this->customer_email_snapshot,
            'customer_whatsapp_snapshot'   => $this->customer_whatsapp_snapshot,
            'user_id'                      => $this->user_id,
            'amount_paid'                  => $this->amount_paid,
            'currency'                     => $this->currency,
            'payment_method'               => $this->payment_method,
            'transaction_id'               => $this->transaction_id,
            'status'                       => $this->status,
            'payment_date'                 => $this->payment_date?->toIso8601String(),
            'has_receipt'                  => !empty($this->image_path),
            'created_at'                   => $this->created_at->toIso8601String(),
        ];
    }
}
