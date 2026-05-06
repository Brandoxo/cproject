<?php

namespace App\Actions\ExternalPanels;

use App\Models\ExternalPanel;
use Lorisleiva\Actions\Concerns\AsAction;

class ChangePanelStatusAction
{
    use AsAction;

    public function handle(ExternalPanel $panel, string $status): ExternalPanel
    {
        $panel->update(['status' => $status]);

        return $panel->fresh();
    }
}
