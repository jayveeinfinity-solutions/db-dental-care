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
            'appointment_id' => $this->appointment_id,
            'appointment' => $this->appointment ?? NULL,
            'patient' => $this->patient ?? NULL,
            'total_amount' => $this->total_amount,
            'status' => $this->status ?? 'completed',
            'checked_in_at' => $this->checked_in_at?->toISOString() ?? ($this->created_at?->toISOString()),
            'checked_out_at' => $this->checked_out_at?->toISOString(),
            'duration_seconds' => $this->duration_seconds,
            'formatted_duration' => $this->formatted_duration,
            'formatted_check_in' => $this->formatted_check_in,
            'formatted_check_out' => $this->formatted_check_out,
            'notes' => $this->notes,
            'services' => $this->services ?? NULL,
            'formatted_date' => $this->formatted_date,
            'history' => $this->history ?? NULL
        ];
    }
}
