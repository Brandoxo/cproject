<?php

namespace App\Http\Requests\ExternalAccounts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'user_id'           => ['sometimes', 'exists:users,id'],
            'cached_username'   => ['sometimes', 'string', 'max:255'],
            'cached_ip_address' => ['sometimes', 'nullable', 'ip'],
            'cached_status'     => ['sometimes', 'in:active,disabled,suspended'],
        ];
    }
}
