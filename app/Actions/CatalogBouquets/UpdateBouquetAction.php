<?php

namespace App\Actions\CatalogBouquets;

use App\Models\CatalogBouquet;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateBouquetAction
{
    use AsAction;

    public function handle(CatalogBouquet $bouquet, array $data): CatalogBouquet
    {
        $bouquet->update(array_filter($data, fn($v) => !is_null($v)));

        return $bouquet->fresh();
    }
}
