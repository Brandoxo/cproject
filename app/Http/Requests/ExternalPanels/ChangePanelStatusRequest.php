<?php

namespace App\Http\Requests\ExternalPanels;

use Illuminate\Foundation\Http\FormRequest;

class ChangePanelStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:active,suspended,maintenance'],
        ];
    }
}
