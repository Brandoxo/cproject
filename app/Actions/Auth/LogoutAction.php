<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class LogoutAction
{
    use AsAction;

    public function handle(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
