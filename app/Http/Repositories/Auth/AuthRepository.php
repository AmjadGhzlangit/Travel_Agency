<?php

namespace App\Http\Repositories\Auth;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthRepository
{
    use ApiResponse;

    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $accessToken = $user->createAuthToken($user->name);
        return $this->respondWithToken($accessToken, $user);
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->user()->tokens()->delete();
            return $this->responseMessage(__('Successfully logged out'));
        } else {
            return $this->responseMessage(__('User is not authenticated'), 401);
        }
    }

    protected function respondWithToken(NewAccessToken $token, $user = null): array
    {
        return [
            'token_type' => 'bearer',
            'access_token' => $token->plainTextToken,
            'access_expires_at' => $token->accessToken->expires_at,
            'user' => $user,
        ];
    }
}
