<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuditLogController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $logs = AuditLog::query()
            ->when(request('user_id'), fn($q) => $q->where('user_id', request('user_id')))
            ->when(request('event'), fn($q) => $q->where('event', request('event')))
            ->when(request('auditable_type'), fn($q) => $q->where('auditable_type', request('auditable_type')))
            ->when(request('date_from'), fn($q) => $q->where('created_at', '>=', request('date_from')))
            ->when(request('date_to'), fn($q) => $q->where('created_at', '<=', request('date_to')))
            ->orderByDesc('created_at')
            ->paginate(20);

        return AuditLogResource::collection($logs);
    }

    public function show(AuditLog $auditLog): AuditLogResource
    {
        return new AuditLogResource($auditLog);
    }
}
