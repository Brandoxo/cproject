<?php

namespace App\Actions\ExternalAccounts;

use App\Models\ExternalAccount;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAccountAction
{
    use AsAction;

    public function handle(ExternalAccount $account, array $data): ExternalAccount
    {
        $account->update(array_filter($data, fn($v) => !is_null($v)));

        return $account->fresh();
    }
}
