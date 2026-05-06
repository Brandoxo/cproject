<?php

namespace App\Actions\Etl;

use App\Models\EtlScrapingJob;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;

class RetryEtlJobAction
{
    use AsAction;

    public const MAX_ATTEMPTS = 3;

    public function handle(EtlScrapingJob $job): EtlScrapingJob
    {
        if ($job->status !== 'failed') {
            throw ValidationException::withMessages([
                'status' => 'Solo se pueden reintentar jobs en estado failed.',
            ]);
        }

        if ($job->attempts >= self::MAX_ATTEMPTS) {
            throw ValidationException::withMessages([
                'attempts' => "Límite de {$job->attempts} intentos alcanzado.",
            ]);
        }

        $job->update([
            'status'        => 'pending',
            'attempts'      => $job->attempts + 1,
            'error_message' => null,
            'started_at'    => null,
            'finished_at'   => null,
        ]);

        return $job->fresh();
    }
}
