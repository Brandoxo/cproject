<?php

namespace App\Http\Requests\CatalogPackages;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'name'           => ['sometimes', 'string', 'max:255'],
            'price_credits'  => ['sometimes', 'numeric', 'min:0'],
            'duration_value' => ['sometimes', 'integer', 'min:1'],
            'duration_unit'  => ['sometimes', 'in:hours,days,months,years'],
            'is_active'      => ['sometimes', 'boolean'],
        ];
    }
}
