<?php

namespace App\Http\Requests\Ledger;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'external_account_id'      => ['required', 'exists:external_accounts,id'],
            'balance_after_transaction' => ['required', 'numeric'],
            'admin_adjustment_reason'  => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }
}
