<?php

namespace App\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:completed,pending,failed,refunded'],
        ];
    }
}
