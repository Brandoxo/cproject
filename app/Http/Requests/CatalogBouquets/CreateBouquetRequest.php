<?php

namespace App\Http\Requests\CatalogBouquets;

use Illuminate\Foundation\Http\FormRequest;

class CreateBouquetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'external_bouquet_id' => ['required', 'integer'],
            'name'                => ['required', 'string', 'max:255'],
            'is_active'           => ['sometimes', 'boolean'],
        ];
    }
}
