<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ExternalAccounts\CreateAccountAction;
use App\Actions\ExternalAccounts\SyncAccountBalanceAction;
use App\Actions\ExternalAccounts\UpdateAccountAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExternalAccounts\CreateAccountRequest;
use App\Http\Requests\ExternalAccounts\UpdateAccountRequest;
use App\Http\Resources\EtlJobResource;
use App\Http\Resources\ExternalAccountResource;
use App\Models\ExternalAccount;
use App\Models\ExternalPanel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExternalAccountController extends Controller
{
    public function index(ExternalPanel $panel): AnonymousResourceCollection
    {
        return ExternalAccountResource::collection($panel->externalAccounts()->paginate(20));
    }

    public function store(CreateAccountRequest $request, ExternalPanel $panel, CreateAccountAction $action): ExternalAccountResource
    {
        return new ExternalAccountResource($action->handle($panel, $request->validated()));
    }

    public function show(ExternalPanel $panel, ExternalAccount $account): ExternalAccountResource
    {
        return new ExternalAccountResource($account);
    }

    public function update(UpdateAccountRequest $request, ExternalPanel $panel, ExternalAccount $account, UpdateAccountAction $action): ExternalAccountResource
    {
        return new ExternalAccountResource($action->handle($account, $request->validated()));
    }

    public function destroy(ExternalPanel $panel, ExternalAccount $account): JsonResponse
    {
        $account->delete();

        return response()->json(['message' => 'Cuenta eliminada correctamente.']);
    }

    public function sync(ExternalPanel $panel, ExternalAccount $account, SyncAccountBalanceAction $action): EtlJobResource
    {
        return new EtlJobResource($action->handle($account));
    }
}
