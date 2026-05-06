<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Ledger\CreateAdjustmentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ledger\CreateAdjustmentRequest;
use App\Http\Resources\LedgerResource;
use App\Models\CreditTransactionLedger;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LedgerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $entries = CreditTransactionLedger::query()
            ->when(request('external_account_id'), fn($q) => $q->where('external_account_id', request('external_account_id')))
            ->when(request('transaction_type'), fn($q) => $q->where('transaction_type', request('transaction_type')))
            ->when(request('date_from'), fn($q) => $q->where('created_at', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->where('created_at', '<=', request('date_to')))
            ->orderByDesc('created_at')
            ->paginate(20);

        return LedgerResource::collection($entries);
    }

    public function show(CreditTransactionLedger $ledger): LedgerResource
    {
        return new LedgerResource($ledger);
    }

    public function adjustment(CreateAdjustmentRequest $request, CreateAdjustmentAction $action): LedgerResource
    {
        return new LedgerResource($action->handle($request->validated()));
    }
}
