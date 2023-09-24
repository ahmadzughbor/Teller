<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TellerProcessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->wallet->user->name,
            'wallet_id' => $this->wallet_id,
            'balance_before' => $this->balance_before,
            'balance_after' => $this->balance_after,
            'amount_before' => $this->amount_before,
            'amount_after' => $this->amount_after,
            'tax_value' => $this->tax_value,
            'date' => $this->created_at,
        ];
    }
}
