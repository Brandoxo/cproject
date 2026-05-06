<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Payments\CreatePaymentAction;
use App\Actions\Payments\UpdatePaymentStatusAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\CreatePaymentRequest;
use App\Http\Requests\Payments\UpdatePaymentStatusRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $payments = Payment::query()
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('crm_customer_id'), fn($q) => $q->where('crm_customer_id', request('crm_customer_id')))
            ->when(request('date_from'), fn($q) => $q->where('payment_date', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->where('payment_date', '<=', request('date_to')))
            ->orderByDesc('payment_date')
            ->paginate(20);

        return PaymentResource::collection($payments);
    }

    public function store(CreatePaymentRequest $request, CreatePaymentAction $action): PaymentResource
    {
        return new PaymentResource($action->handle($request, $request->validated()));
    }

    public function show(Payment $payment): PaymentResource
    {
        return new PaymentResource($payment);
    }

    public function updateStatus(UpdatePaymentStatusRequest $request, Payment $payment, UpdatePaymentStatusAction $action): PaymentResource
    {
        return new PaymentResource($action->handle($payment, $request->status));
    }

    public function receipt(Payment $payment): JsonResponse
    {
        if (!$payment->image_path) {
            return response()->json(['message' => 'Este pago no tiene comprobante adjunto.'], 404);
        }

        return response()->json([
            'url' => Storage::disk('private')->temporaryUrl($payment->image_path, now()->addMinutes(30)),
        ]);
    }
}
