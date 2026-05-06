<?php

namespace App\Actions\CatalogBouquets;

use App\Models\CatalogBouquet;
use App\Models\ExternalPanel;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateBouquetAction
{
    use AsAction;

    public function handle(ExternalPanel $panel, array $data): CatalogBouquet
    {
        return CatalogBouquet::create(array_merge($data, [
            'external_panel_id' => $panel->id,
        ]));
    }
}
