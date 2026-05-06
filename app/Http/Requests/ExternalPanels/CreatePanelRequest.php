<?php

namespace App\Http\Requests\ExternalPanels;

use Illuminate\Foundation\Http\FormRequest;

class CreatePanelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'panel_name' => ['required', 'string', 'max:255'],
            'api_url'    => ['required', 'url', 'max:500'],
            'api_key'    => ['required', 'string'],
            'panel_type' => ['required', 'string', 'max:100'],
            'status'     => ['sometimes', 'in:active,suspended,maintenance'],
        ];
    }
}
