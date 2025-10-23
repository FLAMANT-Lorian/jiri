<?php

namespace App\Http\Requests;

use App\Enums\ContactRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (url()->current() === route('contacts.store')) {
            return [
                'name' => 'required',
                'email' => 'required|email:rfc|unique:contacts',
                'jiris' => 'nullable',
                'jiris.*.role' => Rule::enum(ContactRoles::class),
                'avatar' => 'nullable|image'
            ];
        } /*else {
            return [
                'name' => 'required',
                'email' => 'required|email:rfc',
                'jiris' => 'nullable',
                'jiris.*.role' => Rule::enum(ContactRoles::class),
                'avatar' => 'nullable|image'
            ];
        }*/
    }
}
