<?php

namespace App\Http\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthRepository
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $accessToken = $user->createAuthToken($user->name, 30);

        return $this->respondWithToken($accessToken, $user);
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
