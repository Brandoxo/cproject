<?php

namespace App\Http\Requests\ExternalPanels;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePanelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'panel_name' => ['sometimes', 'string', 'max:255'],
            'api_url'    => ['sometimes', 'url', 'max:500'],
            'api_key'    => ['sometimes', 'string'],
            'panel_type' => ['sometimes', 'string', 'max:100'],
        ];
    }
}
