<?php

namespace App\Actions\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserAction
{
    use AsAction;

    public function handle(User $user, array $data): User
    {
        $user->update(array_filter($data, fn($v) => !is_null($v)));

        return $user->fresh();
    }
}
