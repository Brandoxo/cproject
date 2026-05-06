<?php

namespace App\Http\Requests\ExternalAccounts;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'external_user_id'  => ['required', 'integer'],
            'user_id'           => ['required', 'exists:users,id'],
            'cached_username'   => ['nullable', 'string', 'max:255'],
            'cached_ip_address' => ['nullable', 'ip'],
            'cached_status'     => ['sometimes', 'in:active,disabled,suspended'],
            'credit_balance'    => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
