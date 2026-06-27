<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'contact_id' => [
                'required',
                'integer',
                Rule::exists('contacts', 'id')->where('created_by', $this->user()->id),
            ],
            'appointment_date' => 'required|date',
            'appointment_address' => 'required|max:7',
            'appointment_start_time' => 'required',
        ];
    }
}
