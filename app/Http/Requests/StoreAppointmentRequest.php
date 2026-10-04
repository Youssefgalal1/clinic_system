<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id'          => ['required', 'exists:users,id'],
            'doctor_id'        => ['required', 'exists:doctors,id'],
            'clinic_id'        => ['required', 'exists:clinics,id'],
            'appointment_date' => ['required', 'date_format:Y-m-d H:i:s', 'after:now'],
            'status'           => ['in:pending,confirmed,cancelled,completed'],
        ];
    }
}
