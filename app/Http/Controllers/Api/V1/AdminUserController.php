<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UpdateUserStatusRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminUserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()
            ->latest('id')
            ->paginate(20);

        return response()->json([
            'users' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ],
        ]);
    }

    public function updateStatus(UpdateUserStatusRequest $request, int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);
        $wasActive = $user->is_active;

        $user->is_active = $request->boolean('is_active');
        $user->save();

        if ($wasActive && ! $user->is_active) {
            $user->tokens()->delete();
        }

        return response()->json([
            'message' => 'User status updated successfully.',
            'user' => new UserResource($user),
        ]);
    }
}
