<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrentUserController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $currentUser = new UserResource($request->user());

        return response()->json($currentUser, Response::HTTP_OK);
    }
}
