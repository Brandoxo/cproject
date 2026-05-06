<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Users\CreateUserAction;
use App\Actions\Users\ToggleUserActiveAction;
use App\Actions\Users\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $users = User::with('roles')
            ->when(request('is_active') !== null, fn($q) => $q->where('is_active', request()->boolean('is_active')))
            ->when(request('role'), fn($q) => $q->role(request('role')))
            ->paginate(20);

        return UserResource::collection($users);
    }

    public function store(CreateUserRequest $request, CreateUserAction $action): UserResource
    {
        return new UserResource($action->handle($request->validated()));
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user->load('roles'));
    }

    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action): UserResource
    {
        return new UserResource($action->handle($user, $request->validated()));
    }

    public function destroy(User $user): JsonResponse
    {
        $activeRoots = User::role('ROOT')->where('is_active', true)->count();

        if ($user->hasRole('ROOT') && $activeRoots <= 1) {
            return response()->json(['message' => 'No se puede eliminar el único ROOT activo.'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    }

    public function toggleActive(User $user, ToggleUserActiveAction $action): UserResource
    {
        return new UserResource($action->handle($user));
    }
}
