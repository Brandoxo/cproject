<?php

namespace App\Actions\ServiceLines;

use App\Models\EtlScrapingJob;
use App\Models\ServiceLine;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncServiceLineAction
{
    use AsAction;

    public function handle(ServiceLine $line): EtlScrapingJob
    {
        return EtlScrapingJob::create([
            'external_panel_id'   => $line->external_panel_id,
            'external_account_id' => $line->external_account_id,
            'job_type'            => 'scrape_lines',
            'target'              => "service_lines.{$line->id}",
            'status'              => 'pending',
        ]);
    }
}
