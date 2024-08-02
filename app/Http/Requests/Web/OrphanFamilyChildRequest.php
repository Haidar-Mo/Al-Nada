<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrphanFamilyChildRequest extends FormRequest
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
        $family = $this->route('id');
        return [
            'name' => ['required', Rule::unique('orphan_family_children', 'name')->where('family_id', $family)],
            'birth_date' => ['required', 'date'],
            'academic_level' => ['required', 'in:غير محدد,ابتدائي ,اعدادي,ثانوي,جامعي'],
            'is_supported' => 'boolean'
        ];
    }
}
