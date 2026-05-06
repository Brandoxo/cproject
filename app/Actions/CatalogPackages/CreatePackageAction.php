<?php

namespace App\Actions\CatalogPackages;

use App\Models\CatalogPackage;
use App\Models\ExternalPanel;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePackageAction
{
    use AsAction;

    public function handle(ExternalPanel $panel, array $data): CatalogPackage
    {
        return CatalogPackage::create(array_merge($data, [
            'external_panel_id' => $panel->id,
        ]));
    }
}
