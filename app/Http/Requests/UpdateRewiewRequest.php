<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRewiewRequest extends FormRequest
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
            'user_id'   => ['required', 'exists:users,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'rating'    => ['required', 'numeric', 'min:1', 'max:9.99'],
            'comment'   => ['required', 'string', 'min:3'],
        ];
    }
}
