<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginUserController extends Controller
{
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $user = User::query()->where('email', $request->validated(['email']))->first();

        if (! $user || ! Hash::check($request->validated(['password']), $user->password)) {
            return response()->json([
                'message' => 'Invalid login credentials',
            ], Response::HTTP_BAD_REQUEST);
        }

        $accessToken = $user->createToken('token')->plainTextToken;

        return response()->json([
                'access_token' => $accessToken,
                'token_type' => 'Bearer',
            ], Response::HTTP_OK
        );
    }
}
