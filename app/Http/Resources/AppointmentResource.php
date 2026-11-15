<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'user_id'             => $this->user_id,
            'scheduled_at'        => $this->scheduled_at,
            'formatted_date'      => $this->formatted_date,
            'status'              => $this->status,
            'notes'               => $this->notes,
            'service'             => $this->service,
            'services'            => $this->services && $this->services->isNotEmpty() ? $this->services : ($this->service ? [$this->service] : []),
            'services_names'      => $this->services && $this->services->isNotEmpty() ? $this->services->pluck('name')->join(', ') : ($this->service?->name ?? ''),
            'patient'             => $this->patient,
            'bookedBy'            => $this->bookedBy,
            'cancelledBy'         => $this->cancelledBy,
            'cancellation_reason' => $this->cancellation_reason,
            'cancelled_at'        => $this->cancelled_at,
            'history'             => $this->transaction?->history ?? null,
            'transaction'         => $this->transaction ? (new TransactionResource($this->transaction))->resolve() : null,
        ];
    }
}
