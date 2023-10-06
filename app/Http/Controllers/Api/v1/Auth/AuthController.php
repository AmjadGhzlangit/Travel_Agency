<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Auth\AuthRepository;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;

/**
 * @group Auth endpoint
 */
class AuthController extends Controller
{
    public function __construct(protected AuthRepository $authRepository)
    {
        $this->middleware(['auth:sanctum'])->only('logout');
    }

    /**
     * Email Login
     *
     * This endpoint lets you log in with specific user
     *
     * @unauthenticated
     *
     * @responseFile storage/responses/auth/login.json
     */
    public function login(LoginRequest $request)
    {
        $userData = $request->validated();
        $user = $this->authRepository->login($userData);

        return $this->showOne($user, LoginResource::class);
    }

    public function logout(LoginRequest $request)
    {
        $userData = $request->validated();
        $user = $this->authRepository->login($userData);

        return $this->showOne($user, LoginResource::class);
    }
}
