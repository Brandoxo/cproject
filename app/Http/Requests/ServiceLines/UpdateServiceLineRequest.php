<?php

namespace App\Http\Requests\ServiceLines;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceLineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'auto_renew'    => ['sometimes', 'boolean'],
            'bouquet_ids'   => ['sometimes', 'array'],
            'bouquet_ids.*' => ['integer', 'exists:catalog_bouquets,id'],
        ];
    }
}
