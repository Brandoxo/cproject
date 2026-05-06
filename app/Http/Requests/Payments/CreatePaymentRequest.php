<?php

namespace App\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('ROOT');
    }

    public function rules(): array
    {
        return [
            'crm_customer_id'   => ['required', 'exists:crm_customers,id'],
            'service_line_id'   => ['nullable', 'exists:service_lines,id'],
            'package_id'        => ['nullable', 'exists:catalog_packages,id'],
            'catalog_package_name' => ['required', 'string', 'max:255'],
            'amount_paid'       => ['required', 'numeric', 'min:0'],
            'currency'          => ['required', 'string', 'size:3'],
            'payment_method'    => ['nullable', 'string', 'max:100'],
            'transaction_id'    => ['nullable', 'string', 'max:255'],
            'payment_date'      => ['required', 'date'],
            'receipt'           => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }
}
