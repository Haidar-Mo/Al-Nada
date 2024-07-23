<?php

namespace App\Http\Requests\Web;

use App\Models\Volunteer;
use App\Rules\SyrianPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
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
        $volunteer = $this->route('id');
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'id_serial_number' => 'required|string|max:255|unique:volunteers,id_serial_number,' . $volunteer,
            'birth_date' => 'required|date|before:today',
            'phone_number' => 'required|string|' . new SyrianPhoneNumber . '|unique:volunteers,phone_number,' . $volunteer,
            'academic_level' => 'required|string|max:255',
            'academic_specialization' => 'required|string|max:255',
        ];
    }
}
