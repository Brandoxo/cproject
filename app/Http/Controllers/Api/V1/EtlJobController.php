<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Etl\DispatchEtlJobAction;
use App\Actions\Etl\RetryEtlJobAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Etl\DispatchEtlJobRequest;
use App\Http\Resources\EtlJobResource;
use App\Models\EtlScrapingJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class EtlJobController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $jobs = EtlScrapingJob::query()
            ->when(request('job_type'), fn($q) => $q->where('job_type', request('job_type')))
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('external_panel_id'), fn($q) => $q->where('external_panel_id', request('external_panel_id')))
            ->when(request('date_from'), fn($q) => $q->where('created_at', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->where('created_at', '<=', request('date_to')))
            ->orderByDesc('created_at')
            ->paginate(20);

        return EtlJobResource::collection($jobs);
    }

    public function store(DispatchEtlJobRequest $request, DispatchEtlJobAction $action): EtlJobResource
    {
        return new EtlJobResource($action->handle($request->validated()));
    }

    public function show(EtlScrapingJob $etlJob): EtlJobResource
    {
        return new EtlJobResource($etlJob);
    }

    public function retry(EtlScrapingJob $etlJob, RetryEtlJobAction $action): EtlJobResource
    {
        return new EtlJobResource($action->handle($etlJob));
    }

    public function cancel(EtlScrapingJob $etlJob): JsonResponse
    {
        if ($etlJob->status === 'running') {
            throw ValidationException::withMessages(['status' => 'No se puede cancelar un job en ejecución.']);
        }

        if ($etlJob->status !== 'pending') {
            throw ValidationException::withMessages(['status' => 'Solo se pueden cancelar jobs en estado pending.']);
        }

        $etlJob->update(['status' => 'failed', 'error_message' => 'Cancelado manualmente.']);

        return response()->json(['message' => 'Job cancelado correctamente.']);
    }
}
