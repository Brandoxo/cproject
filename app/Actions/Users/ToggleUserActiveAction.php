<?php

namespace App\Actions\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ToggleUserActiveAction
{
    use AsAction;

    public function handle(User $user): User
    {
        $user->update(['is_active' => !$user->is_active]);

        return $user->fresh();
    }
}
