<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ExternalPanels\ChangePanelStatusAction;
use App\Actions\ExternalPanels\CreatePanelAction;
use App\Actions\ExternalPanels\UpdatePanelAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExternalPanels\ChangePanelStatusRequest;
use App\Http\Requests\ExternalPanels\CreatePanelRequest;
use App\Http\Requests\ExternalPanels\UpdatePanelRequest;
use App\Http\Resources\ExternalPanelResource;
use App\Models\ExternalPanel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExternalPanelController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ExternalPanelResource::collection(ExternalPanel::paginate(20));
    }

    public function store(CreatePanelRequest $request, CreatePanelAction $action): ExternalPanelResource
    {
        return new ExternalPanelResource($action->handle($request->validated()));
    }

    public function show(ExternalPanel $panel): ExternalPanelResource
    {
        return new ExternalPanelResource($panel);
    }

    public function update(UpdatePanelRequest $request, ExternalPanel $panel, UpdatePanelAction $action): ExternalPanelResource
    {
        return new ExternalPanelResource($action->handle($panel, $request->validated()));
    }

    public function destroy(ExternalPanel $panel): JsonResponse
    {
        $panel->delete();

        return response()->json(['message' => 'Panel eliminado correctamente.']);
    }

    public function changeStatus(ChangePanelStatusRequest $request, ExternalPanel $panel, ChangePanelStatusAction $action): ExternalPanelResource
    {
        return new ExternalPanelResource($action->handle($panel, $request->status));
    }
}
