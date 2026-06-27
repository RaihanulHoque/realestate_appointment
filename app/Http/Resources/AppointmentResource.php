<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact_id' => $this->contact_id,
            'appointment_address' => $this->appointment_address,
            'measured_distance' => $this->measured_distance,
            'appointment_date' => $this->appointment_date,
            'appointment_start_time' => $this->appointment_start_time,
            'departure_time_to_site_office' => $this->departure_time_to_site_office,
            'appointment_end_time' => $this->appointment_end_time,
            'arrival_time_to_agent_office' => $this->arrival_time_to_agent_office,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
