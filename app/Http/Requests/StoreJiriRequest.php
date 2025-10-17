<?php

namespace App\Http\Requests;

use App\Enums\ContactRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJiriRequest extends FormRequest
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
            'name' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
            'projects.*' => 'nullable|integer|exists:projects,id',
            'contacts.*' => 'nullable|array',
            'contacts.*.role' => Rule::Enum(ContactRoles::class),
        ];
    }
}
