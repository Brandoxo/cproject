<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ServiceLines\RevealPasswordAction;
use App\Actions\ServiceLines\SyncServiceLineAction;
use App\Actions\ServiceLines\UpdateServiceLineAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceLines\CreateServiceLineRequest;
use App\Http\Requests\ServiceLines\UpdateServiceLineRequest;
use App\Http\Resources\EtlJobResource;
use App\Http\Resources\ServiceLineResource;
use App\Models\ServiceLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceLineController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $lines = ServiceLine::query()
            ->when(request('cached_status'), fn($q) => $q->where('cached_status', request('cached_status')))
            ->when(request('auto_renew') !== null, fn($q) => $q->where('auto_renew', request()->boolean('auto_renew')))
            ->when(request('panel_id'), fn($q) => $q->where('external_panel_id', request('panel_id')))
            ->when(request('customer_id'), fn($q) => $q->where('crm_customer_id', request('customer_id')))
            ->when(request('expires_from'), fn($q) => $q->where('cached_expiration_date', '>=', request('expires_from')))
            ->when(request('expires_to'), fn($q) => $q->where('cached_expiration_date', '<=', request('expires_to')))
            ->with(['customer', 'package'])
            ->orderBy('cached_expiration_date')
            ->paginate(20);

        return ServiceLineResource::collection($lines);
    }

    public function store(CreateServiceLineRequest $request): JsonResponse
    {
        return response()->json(['message' => 'El aprovisionamiento de líneas requiere LineProvisioningService (fase siguiente).'], 501);
    }

    public function show(ServiceLine $line): ServiceLineResource
    {
        return new ServiceLineResource($line->load(['customer', 'package', 'bouquets']));
    }

    public function update(UpdateServiceLineRequest $request, ServiceLine $line, UpdateServiceLineAction $action): ServiceLineResource
    {
        return new ServiceLineResource($action->handle($line, $request->validated()));
    }

    public function destroy(ServiceLine $line): JsonResponse
    {
        $line->delete();

        return response()->json(['message' => 'Línea eliminada localmente.']);
    }

    public function password(Request $request, ServiceLine $line, RevealPasswordAction $action): JsonResponse
    {
        if (!$request->user()->can('lines.view-secret')) {
            abort(403, 'Sin permiso para ver contraseñas.');
        }

        return response()->json(['password' => $action->handle($request, $line)]);
    }

    public function sync(ServiceLine $line, SyncServiceLineAction $action): EtlJobResource
    {
        return new EtlJobResource($action->handle($line));
    }

    public function expiring(): AnonymousResourceCollection
    {
        $days  = (int) request('days', 7);
        $lines = ServiceLine::where('cached_expiration_date', '<=', now()->addDays($days))
            ->where('cached_status', 'active')
            ->with(['customer', 'package'])
            ->orderBy('cached_expiration_date')
            ->paginate(20);

        return ServiceLineResource::collection($lines);
    }
}
