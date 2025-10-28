<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Http\Requests\SaveContactRequest;
use App\Models\Contact;
use App\Models\Jiri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Concerns\HandleImages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use function Pest\Laravel\delete;

class ContactController extends Controller
{
    use AuthorizesRequests;
    use HandleImages;

    public function index()
    {
        $contacts = Auth::user()->contacts;

        return view('contacts.index', compact('contacts'));
    }

    public function store(SaveContactRequest $request): RedirectResponse
    {

        $validated_data = $request->validated();

        if (request()->hasFile('avatar')) {
            $validated_data['avatar'] = $this->generateAvatarImages($validated_data['avatar']);
        }

        $contact = Auth::user()->contacts()->create($validated_data);

        if (!empty($validated_data['jiris'])) {
            foreach ($validated_data['jiris'] as $id => $jiri) {
                $contact->jiris()->attach($id, ['role' => $jiri['role']]);

                if ($jiri['role'] === ContactRoles::Evaluated->value) {
                    $jiri = Jiri::where('id', $id)->first();
                    $homeworks = $jiri->homeworks()->pluck('id')->toArray();

                    if (!empty($homeworks)) {
                        $contact->homeworks()->attach($homeworks);
                    }
                }
            }
        }

        return redirect(route('contacts.show', $contact));
    }

    public function show(Contact $contact)
    {
        $contact->load([
            'jiris',
            'attendances'
        ]);

        return view('contacts.show', compact('contact'));
    }

    public function create()
    {
        $jiris = Auth::user()->jiris;
        return view('contacts.create', compact('jiris'));
    }

    public function edit(Contact $contact)
    {
        $jiris = Auth::user()->jiris;

        return view('contacts.edit', compact('contact', 'jiris'));
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $this->authorize('update', $contact);

        $validated_data = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('contacts')->ignore($contact->id)
            ],
            'jiris' => 'nullable',
            'jiris.*.role' => Rule::enum(ContactRoles::class),
            'avatar' => 'nullable|image'
        ]);

        if (request()->hasFile('avatar')) {

            if ($contact->avatar && Storage::disk('public')->exists('contacts/original/' . $contact->avatar)) {
                Storage::disk('public')->delete('contacts/original/' . $contact->avatar);
                $sizes = config('avatars.sizes');

                foreach ($sizes as $size) {
                    Storage::disk('public')->delete('contacts/variant/' . $size['width'] . 'x' . $size['height'] . '/' . $contact->avatar);
                }
            }
            $validated_data['avatar'] = $this->generateAvatarImages($validated_data['avatar']);
        }

        $contact->upsert(
            [
                [
                    'id' => $contact->id,
                    'user_id' => auth()->user()->id,
                    'email' => $validated_data['email'],
                    'name' => $validated_data['name'],
                    'avatar' => $validated_data['avatar'] ?? $contact->avatar,
                ]
            ],
            'id',
            ['name', 'email', 'avatar'],
        );

        /****** Récupération des anciens jiris pour mettre à jour les implémentations ******/
        $old_jiris_ids = $contact->jiris()->pluck('jiri_id')->toArray();

        /****** Mettre à jour les attendances ******/
        if (!empty($validated_data['jiris'])) {
            $contact->jiris()->sync($validated_data['jiris']);
        } else {
            $contact->jiris()->detach();
        }

        /****** Implementation : Supression d'un ou plusieurs jiris ******/
        $new_jiris_ids = array_keys($validated_data['jiris'] ?? []);
        $jiris_to_remove = array_diff($old_jiris_ids, $new_jiris_ids);

        if (!empty($jiris_to_remove)) {
            foreach ($jiris_to_remove as $jiri_to_remove) {
                if ($jiri = Jiri::where('id', '=', $jiri_to_remove)->first()) {
                    $contact->homeworks()->detach();
                }
            }
        }

        /****** Implementation : Changement du rôle du contact dans un jiri ******/
        if (!empty($validated_data['jiris'])) {
            foreach ($validated_data['jiris'] as $jiri_id => $jiri) {
                $correct_jiri = Jiri::where('id', $jiri_id)->first();
                $homeworks_id = $correct_jiri->homeworks()->pluck('id');

                if ($jiri['role'] === ContactRoles::Evaluated->value) {
                    $contact->homeworks()->syncWithoutDetaching($homeworks_id);
                } else {
                    $contact->homeworks()->detach($homeworks_id);
                }
            }
        }


        return redirect(route('contacts.show', $contact->id));
    }
}
