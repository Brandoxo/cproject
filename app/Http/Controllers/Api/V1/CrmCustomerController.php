<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CrmCustomers\CreateCustomerAction;
use App\Actions\CrmCustomers\UpdateCustomerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CrmCustomers\CreateCustomerRequest;
use App\Http\Requests\CrmCustomers\UpdateCustomerRequest;
use App\Http\Resources\CrmCustomerResource;
use App\Models\CrmCustomer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CrmCustomerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $customers = CrmCustomer::query()
            ->when(request('search'), fn($q) => $q->where(function ($q) {
                $q->where('full_name', 'like', '%' . request('search') . '%')
                  ->orWhere('email', 'like', '%' . request('search') . '%')
                  ->orWhere('whatsapp_number', 'like', '%' . request('search') . '%');
            }))
            ->paginate(20);

        return CrmCustomerResource::collection($customers);
    }

    public function store(CreateCustomerRequest $request, CreateCustomerAction $action): CrmCustomerResource
    {
        return new CrmCustomerResource($action->handle($request, $request->validated()));
    }

    public function show(CrmCustomer $customer): CrmCustomerResource
    {
        return new CrmCustomerResource($customer->load('serviceLines'));
    }

    public function update(UpdateCustomerRequest $request, CrmCustomer $customer, UpdateCustomerAction $action): CrmCustomerResource
    {
        return new CrmCustomerResource($action->handle($customer, $request->validated()));
    }

    public function destroy(CrmCustomer $customer): JsonResponse
    {
        $customer->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente.']);
    }
}
