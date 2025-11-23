<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $middleInitial = $this->middle_name
            ? strtoupper(substr($this->middle_name, 0, 1)) . '.'
            : '';

        // Format Name: LAST, FIRST MI.
        $formattedName = trim(
            strtoupper($this->last_name) . ', ' .
            ucwords($this->first_name) . ' ' .
            $middleInitial
        );

        return [
            'id'             => $this->id,
            'code'           => $this->code,
            'name'           => $formattedName,
            'first_name'     => $this->first_name,
            'middle_name'    => $this->middle_name,
            'last_name'      => $this->last_name,
            'sex'            => $this->sex,
            'birthdate'      => Carbon::parse($this->birthdate)->format('Y-m-d'),
            'age'            => Carbon::parse($this->birthdate)->age,
            'contact_number' => $this->contact_number,
            'address'        => $this->address,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
