<?php

namespace App\Http\Requests\ServiceLines;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceLineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'crm_customer_id'     => ['required', 'exists:crm_customers,id'],
            'external_panel_id'   => ['required', 'exists:external_panels,id'],
            'external_account_id' => ['required', 'exists:external_accounts,id'],
            'catalog_package_id'  => ['required', 'exists:catalog_packages,id'],
            'auto_renew'          => ['sometimes', 'boolean'],
            'bouquet_ids'         => ['sometimes', 'array'],
            'bouquet_ids.*'       => ['integer', 'exists:catalog_bouquets,id'],
        ];
    }
}
