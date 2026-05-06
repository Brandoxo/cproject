<?php

namespace App\Http\Requests\CrmCustomers;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'full_name'       => ['required', 'string', 'max:255'],
            'email'           => ['nullable', 'email', "unique:crm_customers,email,NULL,id,user_id,{$userId}"],
            'whatsapp_number' => ['nullable', 'string', 'max:30', "unique:crm_customers,whatsapp_number,NULL,id,user_id,{$userId}"],
            'notes'           => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            if (empty($this->email) && empty($this->whatsapp_number)) {
                $v->errors()->add('contact', 'Se requiere al menos email o número de WhatsApp.');
            }
        });
    }
}
