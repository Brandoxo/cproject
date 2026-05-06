<?php

namespace App\Http\Requests\Etl;

use Illuminate\Foundation\Http\FormRequest;

class DispatchEtlJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'external_panel_id'   => ['required', 'exists:external_panels,id'],
            'external_account_id' => ['nullable', 'exists:external_accounts,id'],
            'job_type'            => ['required', 'in:api_sync,scrape_balance,scrape_lines,network_sniff'],
            'target'              => ['nullable', 'string', 'max:255'],
        ];
    }
}
