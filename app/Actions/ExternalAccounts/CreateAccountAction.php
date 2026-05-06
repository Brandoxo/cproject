<?php

namespace App\Actions\ExternalAccounts;

use App\Models\ExternalAccount;
use App\Models\ExternalPanel;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAccountAction
{
    use AsAction;

    public function handle(ExternalPanel $panel, array $data): ExternalAccount
    {
        return ExternalAccount::create(array_merge($data, [
            'external_panel_id' => $panel->id,
        ]));
    }
}
