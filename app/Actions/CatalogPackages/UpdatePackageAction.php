<?php

namespace App\Actions\CatalogPackages;

use App\Models\CatalogPackage;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePackageAction
{
    use AsAction;

    public function handle(CatalogPackage $package, array $data): CatalogPackage
    {
        $package->update(array_filter($data, fn($v) => !is_null($v)));

        return $package->fresh();
    }
}
