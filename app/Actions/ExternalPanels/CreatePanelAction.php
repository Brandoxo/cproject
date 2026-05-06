<?php

namespace App\Actions\ExternalPanels;

use App\Models\ExternalPanel;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePanelAction
{
    use AsAction;

    public function handle(array $data): ExternalPanel
    {
        return ExternalPanel::create($data);
    }
}
