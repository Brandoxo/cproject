<?php

namespace App\Http\Requests\CatalogBouquets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBouquetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'name'      => ['sometimes', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
