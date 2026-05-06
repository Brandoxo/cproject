<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginAction
{
    use AsAction;

    public function handle(string $username, string $password, string $deviceName = 'api'): array
    {
        $user = User::where('username', $username)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new AuthenticationException('Credenciales incorrectas.');
        }

        if (!$user->is_active) {
            throw new AuthenticationException('Cuenta desactivada. Contacte al administrador.');
        }

        if ($user->hasEnabledTwoFactorAuthentication()) {
            return [
                'requires_2fa'     => true,
                'two_factor_token' => $user->createToken("{$deviceName}:2fa_pending", ['2fa-pending'], now()->addMinutes(10))->plainTextToken,
            ];
        }

        $user->forceFill(['last_login_at' => now()])->save();

        return [
            'requires_2fa' => false,
            'token'        => $user->createToken($deviceName)->plainTextToken,
            'user'         => $user,
        ];
    }
}
