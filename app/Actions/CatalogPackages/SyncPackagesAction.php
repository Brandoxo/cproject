<?php

namespace App\Actions\CatalogPackages;

use App\Models\EtlScrapingJob;
use App\Models\ExternalPanel;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncPackagesAction
{
    use AsAction;

    public function handle(ExternalPanel $panel): EtlScrapingJob
    {
        return EtlScrapingJob::create([
            'external_panel_id' => $panel->id,
            'job_type'          => 'api_sync',
            'target'            => 'catalog_packages',
            'status'            => 'pending',
        ]);
    }
}
