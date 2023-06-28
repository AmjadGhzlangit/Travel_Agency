<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\loginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(loginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'error' => 'the casad',
                ],
                422
            );
        }

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
        ]);
    }
}
