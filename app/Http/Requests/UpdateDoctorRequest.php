<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
            'user_id'           => ['required', 'exists:users,id'],
            'specialization_id' => ['required', 'exists:specializations,id'],
            'title'             => ['required', 'in:Dr.,Prof.,Consultant'],
            'bio'               => ['required', 'string', 'min:10'],
            'fees'              => ['required', 'integer', 'min:100'],
            'experience_years'  => ['required', 'integer', 'min:1', 'max:50'],
            'rating'            => ['nullable', 'numeric', 'min:1', 'max:9.99'],
        ];
    }
}
