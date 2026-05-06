<?php

namespace App\Actions\Ledger;

use App\Models\CreditTransactionLedger;
use App\Models\ExternalAccount;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAdjustmentAction
{
    use AsAction;

    public function handle(array $data): CreditTransactionLedger
    {
        $account = ExternalAccount::findOrFail($data['external_account_id']);

        $entry = CreditTransactionLedger::create([
            'transaction_id'            => (string) Str::uuid(),
            'external_account_id'       => $account->id,
            'transaction_type'          => 'admin_adjustment',
            'balance_after_transaction' => $data['balance_after_transaction'],
            'admin_adjustment_reason'   => $data['admin_adjustment_reason'],
        ]);

        $account->update(['credit_balance' => $data['balance_after_transaction']]);

        return $entry;
    }
}
