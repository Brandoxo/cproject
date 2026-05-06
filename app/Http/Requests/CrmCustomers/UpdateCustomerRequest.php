<?php

namespace App\Http\Requests\CrmCustomers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId     = $this->user()->id;
        $customerId = $this->route('customer');

        return [
            'full_name'       => ['sometimes', 'string', 'max:255'],
            'email'           => ['nullable', 'email', Rule::unique('crm_customers', 'email')->where('user_id', $userId)->ignore($customerId)],
            'whatsapp_number' => ['nullable', 'string', 'max:30', Rule::unique('crm_customers', 'whatsapp_number')->where('user_id', $userId)->ignore($customerId)],
            'notes'           => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            $email    = $this->email    ?? $this->route('customer')?->email;
            $whatsapp = $this->whatsapp_number ?? $this->route('customer')?->whatsapp_number;

            if (empty($email) && empty($whatsapp)) {
                $v->errors()->add('contact', 'Se requiere al menos email o número de WhatsApp.');
            }
        });
    }
}
