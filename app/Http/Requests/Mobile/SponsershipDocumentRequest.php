<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class SponsershipDocumentRequest extends FormRequest
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
        $document = $this->route('id');
        return [
            'fixed_phone_number' => ['nullable', 'unique:sponsership_documents,fixed_phone_number,' . $document . ',id'],
            'address' => ['required', 'string'],
            'academic_level' => ['required', 'in:غير محدد,ابتدائي,اعدادي,ثانوي,جامعي'],
            'job' => ['required', 'string'],
            'job_address' => ['nullable'],
            'communicate_by_phone' => ['boolean'],
            'communicate_by_text_messages' => ['boolean'],
            'communicate_by_email' => ['boolean'],
            'communicate_with_the_sponsered_person' => ['boolean'],
            'available' => ['boolean'],
            'participate_in_activities' => ['boolean'],
            'recognizing_way' => ['nullable', 'string']
        ];
    }
}
