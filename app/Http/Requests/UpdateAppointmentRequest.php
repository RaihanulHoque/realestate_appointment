<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'contact_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('contacts', 'id')->where('created_by', $this->user()->id),
            ],
            'appointment_address' => 'sometimes|required|max:255',
            'measured_distance' => 'sometimes|required',
            'appointment_date' => 'sometimes|required|date',
            'appointment_start_time' => 'sometimes|required',
            'departure_time_to_site_office' => 'sometimes|required',
            'appointment_end_time' => 'sometimes|required',
            'arrival_time_to_agent_office' => 'sometimes|required',
        ];
    }
}
