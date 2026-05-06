<?php

namespace App\Actions\ServiceLines;

use App\Models\AuditLog;
use App\Models\ServiceLine;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class RevealPasswordAction
{
    use AsAction;

    public function handle(Request $request, ServiceLine $line): string
    {
        AuditLog::create([
            'user_id'        => $request->user()->id,
            'auditable_type' => ServiceLine::class,
            'auditable_id'   => $line->id,
            'event'          => 'password_revealed',
            'ip_address'     => $request->ip(),
            'user_agent'     => $request->userAgent(),
        ]);

        return $line->cached_password;
    }
}
