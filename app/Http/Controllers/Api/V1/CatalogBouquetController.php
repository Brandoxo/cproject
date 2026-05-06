<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CatalogBouquets\CreateBouquetAction;
use App\Actions\CatalogBouquets\SyncBouquetsAction;
use App\Actions\CatalogBouquets\UpdateBouquetAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogBouquets\CreateBouquetRequest;
use App\Http\Requests\CatalogBouquets\UpdateBouquetRequest;
use App\Http\Resources\CatalogBouquetResource;
use App\Http\Resources\EtlJobResource;
use App\Models\CatalogBouquet;
use App\Models\ExternalPanel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CatalogBouquetController extends Controller
{
    public function index(ExternalPanel $panel): AnonymousResourceCollection
    {
        $bouquets = $panel->catalogBouquets()
            ->when(request()->has('is_active'), fn($q) => $q->where('is_active', request()->boolean('is_active')))
            ->paginate(20);

        return CatalogBouquetResource::collection($bouquets);
    }

    public function store(CreateBouquetRequest $request, ExternalPanel $panel, CreateBouquetAction $action): CatalogBouquetResource
    {
        return new CatalogBouquetResource($action->handle($panel, $request->validated()));
    }

    public function show(ExternalPanel $panel, CatalogBouquet $bouquet): CatalogBouquetResource
    {
        return new CatalogBouquetResource($bouquet);
    }

    public function update(UpdateBouquetRequest $request, ExternalPanel $panel, CatalogBouquet $bouquet, UpdateBouquetAction $action): CatalogBouquetResource
    {
        return new CatalogBouquetResource($action->handle($bouquet, $request->validated()));
    }

    public function destroy(ExternalPanel $panel, CatalogBouquet $bouquet): JsonResponse
    {
        $bouquet->delete();

        return response()->json(['message' => 'Bouquet eliminado correctamente.']);
    }

    public function sync(ExternalPanel $panel, SyncBouquetsAction $action): EtlJobResource
    {
        return new EtlJobResource($action->handle($panel));
    }
}
