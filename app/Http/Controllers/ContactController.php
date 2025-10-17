<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Concerns\HandleImages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ContactController extends Controller
{
    use AuthorizesRequests;
    use HandleImages;
    public function index()
    {
        $contacts = Auth::user()->contacts;

        return view('contacts.index', compact('contacts'));
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $validated_data = $request->validated();

        if (request()->hasFile('avatar')) {
            $validated_data['avatar'] = $this->generateAllSizedImages($validated_data['avatar']);
        }

        $contact = Auth::user()->contacts()->create($validated_data);

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

        return redirect(route('contacts.show', $contact));
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    public function create()
    {
        $jiris = Auth::user()->jiris;
        return view('contacts.create', compact('jiris'));
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Contact $contact)
    {
        $this->authorize('update', $contact);

        // TODO : Faire la validation

        return redirect(route('contacts.show',$contact->id));
    }
}
