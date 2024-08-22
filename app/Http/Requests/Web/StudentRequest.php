<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'adress' => 'required|string|max:255',
            'university' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'study_start_year' => 'required|integer|min:2000|max:' . date('Y'),
            'expected_graduation_year' => 'required|integer|min:1900|max:' . date('Y', strtotime('+10 years')),
            'actual_graduation_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'mobile_number' => 'required|string|max:15|unique:students,mobile_number,' . $id . 'id', // Adjust your_table_name
            'landline_number' => 'nullable|string|max:15',
            'personal_card_image' => 'required|image',
            'description' => 'nullable|string',
            'is_supported' => 'required|boolean',
            'visible' => 'required|boolean',
            'min_sponsorship_payment' => 'required|integer|min:0',
        ];
    }
}
