<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\SyrianPhoneNumber;

class VolunteerInCampaignRequest extends FormRequest
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
            'campaign_id'=>'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => ['required', new SyrianPhoneNumber, 'unique:volunteers,phone_number,' . $volunteer],
            'academic_level' => 'required|string|max:255',
            'city_id' => ['required'],
            'address' => ['required', 'string']
        ];
    }
}
