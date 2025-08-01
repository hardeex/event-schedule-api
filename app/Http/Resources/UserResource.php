<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'email_verification_token' => $this->email_verification_token,
            'role' => $this->role,
            'email_verified' => (bool) $this->email_verified_at,
            'account_created_at' => $this->created_at,
            'last_account_update' => $this->updated_at
        ];
    }
}
