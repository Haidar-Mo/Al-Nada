<?php

namespace App\Http\Requests\Web;

use App\Models\Administration;
use App\Rules\SyrianPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
        $employee = $this->route('id');
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'father_name' => ['required', 'string'],
            'mother_name' => ['required', 'string'],
            'phone_number' => ['required', new SyrianPhoneNumber, 'unique:employees,phone_number,' . $employee . ',id'],
            'id_serial_number' => ['required', 'min:11', 'max:11', 'unique:employees,id_serial_number,' . $employee . ',id'],
            'nationality' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
            'academic_specialization' => ['required', 'string'],
            'academic_level' => ['required', 'string', 'in:ابتدائي,اعدادي,ثانوي,جامعي'],
            'social_situation' => ['required', 'string', 'in:أعزب,متزوج,مطلق,ارمل'],
            'date_start_working' => ['required', 'date'],
            'date_end_working' => ['nullable','date'],
            'section_id' => ['required', 'string'],
            'image' => ['nullable', 'image']
        ];
    }
}
