<?php

namespace App\Actions\CrmCustomers;

use App\Models\CrmCustomer;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCustomerAction
{
    use AsAction;

    public function handle(CrmCustomer $customer, array $data): CrmCustomer
    {
        $customer->update(array_filter($data, fn($v) => !is_null($v)));

        return $customer->fresh();
    }
}
