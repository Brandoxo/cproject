<?php

namespace App\Actions\ExternalPanels;

use App\Models\ExternalPanel;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePanelAction
{
    use AsAction;

    public function handle(ExternalPanel $panel, array $data): ExternalPanel
    {
        $panel->update(array_filter($data, fn($v) => !is_null($v)));

        return $panel->fresh();
    }
}
