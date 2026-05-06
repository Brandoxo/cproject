<?php

namespace App\Actions\CrmCustomers;

use App\Models\CrmCustomer;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCustomerAction
{
    use AsAction;

    public function handle(Request $request, array $data): CrmCustomer
    {
        return CrmCustomer::create([
            'user_id'          => $request->user()->id,
            'full_name'        => $data['full_name'],
            'email'            => $data['email'] ?? null,
            'whatsapp_number'  => $data['whatsapp_number'] ?? null,
            'notes'            => $data['notes'] ?? null,
        ]);
    }
}
