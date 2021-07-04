<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'first_name' => $this->first_name,
             'last_name' => $this->last_name,
             'email' => $this->email,
             'phone_number' => $this->phone_number,
             'eligible_amount' => $this->eligible_amount,
             'initial_amount' => $this->userWallet->initial_amount,
             'actual_amount' => $this->userWallet->actual_amount,
              //   'expires_at' => now()->addSeconds(auth()->factory()->getTTL() * 60)->timestamp,
            
        ];
    }
}
