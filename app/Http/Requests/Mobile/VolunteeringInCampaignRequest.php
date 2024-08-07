<?php

namespace App\Http\Requests\Mobile;

use App\Rules\SyrianPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class VolunteeringInCampaignRequest extends FormRequest
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
            'phone_number'=>['required',new SyrianPhoneNumber],
            'reason_for_volunteering' => ['required', 'string'],
            'academic_level' => ['required',],
            'address' => ['required', 'string']

        ];
    }
}
