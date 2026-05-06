<?php

namespace App\Actions\ExternalAccounts;

use App\Models\EtlScrapingJob;
use App\Models\ExternalAccount;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncAccountBalanceAction
{
    use AsAction;

    public function handle(ExternalAccount $account): EtlScrapingJob
    {
        return EtlScrapingJob::create([
            'external_panel_id'   => $account->external_panel_id,
            'external_account_id' => $account->id,
            'job_type'            => 'scrape_balance',
            'target'              => 'external_accounts.credit_balance',
            'status'              => 'pending',
        ]);
    }
}
