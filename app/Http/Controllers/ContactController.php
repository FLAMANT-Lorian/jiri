<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Implementation;
use App\Models\Jiri;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return view('contacts.index', compact('contacts'));
    }

    public function store()
    {
        $validated_data = request()->validate([
            'name' => 'required',
            'email' => 'required|email:rfc|unique:contacts',
            'jiris' => 'nullable',
            'jiris.*.role' => Rule::enum(ContactRoles::class),
            'jiris.*.homeworks' => 'nullable|array',
            'jiris.*.homeworks.*' => 'nullable|integer|exists:homeworks,id',
        ]);

        $contact = Contact::create($validated_data);

        if (!empty($validated_data['jiris'])) {
            foreach ($validated_data['jiris'] as $id => $jiri) {
                $contact->jiris()->attach($id, ['role' => $jiri['role']]);

                if ($jiri['role'] === ContactRoles::Evaluated->value) {
                    foreach ($jiri['homeworks'] as $homework_id) {
                        $contact->homeworks()->attach($homework_id);
                    }
                }
            }
        }

        return redirect(route('contacts.index'));
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    public function create()
    {
        $jiris = Jiri::all();
        return view('contacts.create', compact('jiris'));
    }
}
