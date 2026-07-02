<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'name'            =>['required','string','min:3','max:255'],
            'email'           => ['required', 'email:rfc,dns', 'unique:users,email'],
            // rfc الشكل الكامل  dns: الدومين مثل gmail  unique:users,email:هو بس في الداتا بيز
            'password'        => ['required','confirmed', Password::defaults()],
            'role'            =>['required','in:admin,patient,doctor'],
            'gender'          =>['required','in:male,female'],
            'phone'           => ['required', 'digits:11', 'regex:/^01[0125][0-9]{8}$/'],
            'birth_date'      => ['required','date','before:today',Rule::date()->format('Y-m-d'),],
        ];
    }
}
