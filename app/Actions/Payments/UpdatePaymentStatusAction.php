<?php

namespace App\Actions\Payments;

use App\Models\CreditTransactionLedger;
use App\Models\Payment;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePaymentStatusAction
{
    use AsAction;

    public function handle(Payment $payment, string $status): Payment
    {
        $payment->update(['status' => $status]);

        if ($status === 'refunded') {
            $account = $payment->serviceLine?->account;

            if ($account) {
                CreditTransactionLedger::create([
                    'transaction_id'            => (string) Str::uuid(),
                    'external_account_id'       => $account->id,
                    'transaction_type'          => 'payment_reversal',
                    'balance_after_transaction' => $account->credit_balance,
                    'payment_id'                => $payment->id,
                    'service_line_id'           => $payment->service_line_id,
                ]);
            }
        }

        return $payment->fresh();
    }
}
