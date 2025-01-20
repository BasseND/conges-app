<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // L'autorisation sera gérée par les policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required', Rule::in(['annual', 'sick', 'unpaid', 'other'])],
            'reason' => ['required', 'string', 'min:10', 'max:500'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'La date de début doit être aujourd\'hui ou une date future.',
            'end_date.after_or_equal' => 'La date de fin doit être égale ou postérieure à la date de début.',
            'reason.min' => 'Veuillez fournir une raison plus détaillée (minimum 10 caractères).',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->start_date) {
            $this->merge([
                'start_date' => date('Y-m-d', strtotime($this->start_date)),
            ]);
        }
        if ($this->end_date) {
            $this->merge([
                'end_date' => date('Y-m-d', strtotime($this->end_date)),
            ]);
        }
    }
}
