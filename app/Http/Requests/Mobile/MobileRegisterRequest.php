<?php

namespace App\Http\Requests\Mobile;

use App\Rules\SyrianPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class MobileRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email', 'string'],
            'phone_number' => ['required', 'string', new SyrianPhoneNumber],
            'id_serial_number' => ['required', 'unique:users,id_serial_number', 'string', 'min:11','max:11'],
            'password' => ['required', 'confirmed', 'min:6'],

        ];
    }
}
