<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class OrphanFamilyStatementRequest extends FormRequest
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
            'statement_date' => 'required|date',
            'income_source' => 'required|string',
            'mony_saving' => 'required|numeric|min:0',
            'poor_level' => 'required|string',
            'other_association' => 'nullable|string|max:255',
            'supply' => 'nullable|string',
            'note' => 'nullable|string',
            'committee' => 'required|string',
            'committee_report' => 'required|string|max:255',
            'remove_statement_number' => 'nullable',
            'remove_date' => 'nullable|date',
            'remove_reson' => 'nullable|string|max:255',
        ];
    }
}
