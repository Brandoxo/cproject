<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $result = $action->handle(
            $request->username,
            $request->password,
            $request->device_name ?? 'api'
        );

        if ($result['requires_2fa']) {
            return response()->json([
                'requires_2fa'     => true,
                'two_factor_token' => $result['two_factor_token'],
            ]);
        }

        return response()->json([
            'requires_2fa' => false,
            'token'        => $result['token'],
            'user'         => new UserResource($result['user']),
        ]);
    }

    public function logout(Request $request, LogoutAction $action): JsonResponse
    {
        $action->handle($request);

        return response()->json(['message' => 'Sesión cerrada correctamente.']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['data' => new UserResource($request->user())]);
    }
}
