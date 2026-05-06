<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationLogResource;
use App\Models\NotificationLog;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationLogController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $logs = NotificationLog::query()
            ->when(request('notification_type'), fn($q) => $q->where('notification_type', request('notification_type')))
            ->when(request('channel'), fn($q) => $q->where('channel', request('channel')))
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->when(request('service_line_id'), fn($q) => $q->where('service_line_id', request('service_line_id')))
            ->when(request('crm_customer_id'), fn($q) => $q->where('crm_customer_id', request('crm_customer_id')))
            ->orderByDesc('sent_at')
            ->paginate(20);

        return NotificationLogResource::collection($logs);
    }

    public function show(NotificationLog $notificationLog): NotificationLogResource
    {
        return new NotificationLogResource($notificationLog);
    }
}
