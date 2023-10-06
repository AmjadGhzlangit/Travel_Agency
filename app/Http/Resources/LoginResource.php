<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token_type' => $this['token_type'],
            'access_token' => $this['access_token'],
            'access_expires_at' => $this['access_expires_at'],
            'profile' => new UserResource($this['user']),
        ];
    }
}
