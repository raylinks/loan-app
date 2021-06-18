<?php

namespace App\Http\Resources\Business\Team;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateAccountResource extends JsonResource
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
            'bvn' => $this->id,
            'account_number' => $this->first_name,
            'account_name' => $this->last_name,
            'email' => $this->email,
            'customer_name' => $this->profile_picture,
            'user' => $this->phone,
            'status' => $this->pivot->status,
        ];
    }
}
