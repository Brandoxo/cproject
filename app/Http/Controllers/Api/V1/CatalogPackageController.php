<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\CatalogPackages\CreatePackageAction;
use App\Actions\CatalogPackages\SyncPackagesAction;
use App\Actions\CatalogPackages\UpdatePackageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogPackages\CreatePackageRequest;
use App\Http\Requests\CatalogPackages\UpdatePackageRequest;
use App\Http\Resources\CatalogPackageResource;
use App\Http\Resources\EtlJobResource;
use App\Models\CatalogPackage;
use App\Models\ExternalPanel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CatalogPackageController extends Controller
{
    public function index(ExternalPanel $panel): AnonymousResourceCollection
    {
        $packages = $panel->catalogPackages()
            ->when(request()->has('is_active'), fn($q) => $q->where('is_active', request()->boolean('is_active')))
            ->paginate(20);

        return CatalogPackageResource::collection($packages);
    }

    public function store(CreatePackageRequest $request, ExternalPanel $panel, CreatePackageAction $action): CatalogPackageResource
    {
        return new CatalogPackageResource($action->handle($panel, $request->validated()));
    }

    public function show(ExternalPanel $panel, CatalogPackage $package): CatalogPackageResource
    {
        return new CatalogPackageResource($package);
    }

    public function update(UpdatePackageRequest $request, ExternalPanel $panel, CatalogPackage $package, UpdatePackageAction $action): CatalogPackageResource
    {
        return new CatalogPackageResource($action->handle($package, $request->validated()));
    }

    public function destroy(ExternalPanel $panel, CatalogPackage $package): JsonResponse
    {
        $package->delete();

        return response()->json(['message' => 'Paquete eliminado correctamente.']);
    }

    public function sync(ExternalPanel $panel, SyncPackagesAction $action): EtlJobResource
    {
        return new EtlJobResource($action->handle($panel));
    }
}
