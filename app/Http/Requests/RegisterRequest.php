<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name'            => ['required','string','min:3','max:255'],
            'email'           => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password'        => ['required','confirmed', Password::defaults()],
            'gender'          => ['required','in:male,female'],
            'phone'           => ['required', 'digits:11', 'regex:/^01[0125][0-9]{8}$/'],
            'birth_date'      => ['required', 'date_format:Y-m-d', 'before:today']
        ];
    }
}
