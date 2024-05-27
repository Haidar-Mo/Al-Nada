<?php

namespace App\Http\Requests\Mobile;

use App\Rules\SyrianPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class VolunteeringRequest extends FormRequest
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
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'social_situation' => 'required|string|in:أعزب,متزوج,مطلق,ارمل',
            'partner_name' => 'string|max:255',
            'fixed_phone_number' => 'string|max:15',
            'user_work' => 'string|max:255',
            'father_work' => 'string|max:255',
            'mother_work' => 'string|max:255',
            'partner_work' => 'string|max:255',
            'number_of_sons' => 'required|integer|min:0',
            'birth_date_of_sons' => 'json',
            'number_of_daughters' => 'required|integer|min:0',
            'birth_date_of_daughters' => 'json',
            'address' => 'required|string|max:255',
            'languages' => 'required|json',
            'assistance_can_be_provided' => 'required|string',
            'computer_useability_level' => 'required|in:مبتدأ,متوسط,متقدم',
            'old_experience' => 'string|max:255',
            'hopies' => 'string|max:255',
            'recognation_way' => 'required|string|max:255',
            'joining_reason' => 'required|string|max:255',
            'old_association' => 'string|max:255',
            'job_in_old_association' => 'string|max:255',
            'leave_reason' => 'string|max:255',
            'id_card_image' => 'image',
            'personal_image' => 'image',
            //'status' => ['required', 'in:انتظار,مقبول,مرفوض,منتهي'],
            //'rejecting_reason' => ['nullable', 'string'],
            //'start_date' => ['required', 'date'],
            //'end_date' => ['required', 'date']
        ];
    }
}
