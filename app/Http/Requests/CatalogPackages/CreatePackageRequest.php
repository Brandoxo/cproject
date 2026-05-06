<?php

namespace App\Http\Requests\CatalogPackages;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'external_package_id' => ['required', 'integer'],
            'name'                => ['required', 'string', 'max:255'],
            'price_credits'       => ['required', 'numeric', 'min:0'],
            'duration_value'      => ['required', 'integer', 'min:1'],
            'duration_unit'       => ['required', 'in:hours,days,months,years'],
            'is_active'           => ['sometimes', 'boolean'],
        ];
    }
}
