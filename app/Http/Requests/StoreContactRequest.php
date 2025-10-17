<?php

namespace App\Http\Requests;

use App\Enums\ContactRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
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
            'email' => 'required|email:rfc|unique:contacts',
            'jiris' => 'nullable',
            'jiris.*.role' => Rule::enum(ContactRoles::class),
            'jiris.*.homeworks' => 'nullable|array',
            'jiris.*.homeworks.*' => 'nullable|integer|exists:homeworks,id',
            'avatar' => 'nullable|image'
        ];
    }
}
