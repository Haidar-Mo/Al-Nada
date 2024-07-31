<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class OrphanFamilyRequest extends FormRequest
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
        $record = $this->route('id');
        return [
            'mother_first_name' => 'required|string|max:255',
            'mother_last_name' => 'required|string|max:255',
            'mother_birthplace' => 'required|string|max:255',
            'mother_birthdate' => 'required|date',
            'mother_id_serial_number' => 'required|string|max:255|unique:orphan_families,mother_id_serial_number,' . $record . ',id',
            'mother_nationality' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:orphan_families,phone_number,' . $record . ',id',
            'mother_health_condition' => 'nullable|string|max:255',
            'mother_academic_level' => 'nullable|string|in:غير محدد,ابتدائي ,اعدادي,ثانوي,جامعي',
            'family_register_book_number' => 'required|string|max:255|unique:orphan_families,family_register_book_number,' . $record . ',id',
            'side_from' => 'required|string|max:255',
            'father_first_name' => 'required|string|max:255',
            'father_last_name' => 'required|string|max:255',
            'father_nationality' => 'required|string|max:255',
            'father_death_date' => 'nullable|date',
            'cause_of_death' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'house_ownership_type' => 'required|string|max:255',
            'residents_number' => 'required|integer|min:1',
            'sons_number' => 'required|integer|min:0',
            'daughter_number' => 'required|integer|min:0',
            'value_rent' => 'nullable|numeric|min:0',
            'zip_code' => 'required|string|max:10',
            'supervisor_name' => 'required|string', 

        ];
    }
}
