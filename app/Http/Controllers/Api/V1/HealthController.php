<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\EtlScrapingJob;
use App\Models\ExternalPanel;
use App\Models\ServiceLine;
use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    public function sync(ExternalPanel $panel): JsonResponse
    {
        $lastSuccess = EtlScrapingJob::where('external_panel_id', $panel->id)
            ->where('status', 'success')
            ->latest('finished_at')
            ->first();

        $ageMinutes = $lastSuccess
            ? (int) $lastSuccess->finished_at->diffInMinutes(now())
            : null;

        return response()->json([
            'panel_id'        => $panel->id,
            'panel_name'      => $panel->panel_name,
            'status'          => $panel->status,
            'last_success_at' => $lastSuccess?->finished_at?->toIso8601String(),
            'age_minutes'     => $ageMinutes,
            'is_stale'        => $ageMinutes === null || $ageMinutes > 120,
        ]);
    }

    public function system(): JsonResponse
    {
        return response()->json([
            'panels_active'   => ExternalPanel::where('status', 'active')->count(),
            'lines_active'    => ServiceLine::where('cached_status', 'active')->count(),
            'jobs_pending'    => EtlScrapingJob::where('status', 'pending')->count(),
            'jobs_failed'     => EtlScrapingJob::where('status', 'failed')
                ->where('created_at', '>=', now()->subHours(24))
                ->count(),
        ]);
    }
}
