<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
        'name' => $this->name,
        'surname' => $this->surname,
        'phone' => $this->phone,
        'address' => $this->address,
        'created_at' => (string) $this->created_at,
        'updated_at' => (string) $this->updated_at,
        // 'created_by' => $this->user,
        // 'appointments' => $this->appointments,
      ];
    }
 
}