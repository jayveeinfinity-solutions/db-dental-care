<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'appointment' => $this->appointment ?? NULL,
            'patient' => $this->patient ?? NULL,
            'total_amount' => $this->total_amount,
            'services' => $this->services ?? NULL,
            'formatted_date' => $this->formatted_date,
            'history' => $this->history ?? NULL
        ];
    }
}
