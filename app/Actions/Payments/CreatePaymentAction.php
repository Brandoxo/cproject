<?php

namespace App\Actions\Payments;

use App\Models\CrmCustomer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePaymentAction
{
    use AsAction;

    public function handle(Request $request, array $data): Payment
    {
        $customer = CrmCustomer::findOrFail($data['crm_customer_id']);

        $imagePath = null;
        if ($request->hasFile('receipt')) {
            $imagePath = $request->file('receipt')->store('payments/receipts', 'private');
        }

        return Payment::create([
            'crm_customer_id'             => $customer->id,
            'service_line_id'             => $data['service_line_id'] ?? null,
            'package_id'                  => $data['package_id'] ?? null,
            'catalog_package_name'        => $data['catalog_package_name'],
            'customer_full_name_snapshot' => $customer->full_name,
            'customer_email_snapshot'     => $customer->email,
            'customer_whatsapp_snapshot'  => $customer->whatsapp_number,
            'user_id'                     => $request->user()->id,
            'amount_paid'                 => $data['amount_paid'],
            'currency'                    => strtoupper($data['currency']),
            'payment_method'              => $data['payment_method'] ?? null,
            'transaction_id'              => $data['transaction_id'] ?? null,
            'payment_date'                => $data['payment_date'],
            'image_path'                  => $imagePath,
            'status'                      => 'pending',
        ]);
    }
}
