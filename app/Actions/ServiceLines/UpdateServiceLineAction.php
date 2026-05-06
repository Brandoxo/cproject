<?php

namespace App\Actions\ServiceLines;

use App\Models\ServiceLine;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateServiceLineAction
{
    use AsAction;

    public function handle(ServiceLine $line, array $data): ServiceLine
    {
        $line->update(array_filter($data, fn($v) => !is_null($v), ARRAY_FILTER_USE_BOTH));

        if (isset($data['bouquet_ids'])) {
            $line->bouquets()->sync($data['bouquet_ids']);
        }

        return $line->load('bouquets');
    }
}
