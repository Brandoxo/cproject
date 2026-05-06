<?php

namespace App\Actions\Etl;

use App\Models\EtlScrapingJob;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class DispatchEtlJobAction
{
    use AsAction;

    public function handle(array $data): EtlScrapingJob
    {
        $running = EtlScrapingJob::where('external_panel_id', $data['external_panel_id'])
            ->where('job_type', $data['job_type'])
            ->where('status', 'running')
            ->exists();

        if ($running) {
            throw ValidationException::withMessages([
                'job_type' => 'Ya existe un job del mismo tipo en ejecución para este panel.',
            ]);
        }

        return EtlScrapingJob::create([
            'external_panel_id'   => $data['external_panel_id'],
            'external_account_id' => $data['external_account_id'] ?? null,
            'job_type'            => $data['job_type'],
            'target'              => $data['target'] ?? null,
            'status'              => 'pending',
        ]);
    }
}
