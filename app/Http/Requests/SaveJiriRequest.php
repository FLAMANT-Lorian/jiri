<?php

namespace App\Http\Requests;

use App\Enums\ContactRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveJiriRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
            'projects.*' => 'nullable|integer|exists:projects,id',
            'contacts.*' => 'nullable|array',
            'contacts.*.role' => Rule::Enum(ContactRoles::class),
        ];
    }
}
