<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JiriController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $jiris = Auth::user()->jiris;

        return view('jiris.index', compact('jiris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated_data = $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
            'projects.*' => 'nullable|integer|exists:projects,id',
            'contacts.*' => 'nullable|array',
            'contacts.*.role' => Rule::Enum(ContactRoles::class),
        ]);

        $jiri = Jiri::create(array_merge(
            $validated_data,
            [
                'user_id' => Auth::user()->id
            ]));

        if (!empty($validated_data['projects'])) {
            $jiri->projects()->attach($validated_data['projects']);
        }

        if (!empty($validated_data['contacts'])) {
            foreach ($validated_data['contacts'] as $id => $contact) {
                $jiri->contacts()->attach($id, ['role' => $contact['role']]);

                if ($contact['role'] === ContactRoles::Evaluated->value) {
                    $correct_contact = Contact::where('id', '=', $id)->first();
                    $homeworks_id = $jiri->homeworks()->pluck('id');
                    $correct_contact->homeworks()->attach($homeworks_id);
                }
            }
        }

        return redirect(route('jiris.index'));
    }

    public function show(Jiri $jiri)
    {
        return view('jiris.show', compact('jiri'));
    }

    public function create()
    {
        $contacts = Contact::all();
        $projects = Project::all();

        return view('jiris.create', compact('contacts', 'projects'));
    }

    public function edit(Jiri $jiri)
    {
        // Récupérer les données du jiri
        $contacts = Contact::all();
        $projects = Project::all();

        return view('jiris.edit', compact('jiri', 'contacts', 'projects'));
    }

    public function update(Request $request, Jiri $jiri): RedirectResponse
    {
        $this->authorize('update', $jiri);

        /****** Validation des données ******/
        $validated_data = $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
            'projects.*' => 'nullable|integer|exists:projects,id',
            'contacts.*' => 'nullable|array',
            'contacts.*.role' => Rule::Enum(ContactRoles::class),
        ]);

        /****** Mise à jour des données du Jiri ******/
        $jiri->upsert(
            [
                [
                    'id' => $jiri->id,
                    'user_id' => Auth::user()->id,
                    'name' => $validated_data['name'],
                    'date' => $validated_data['date'],
                    'description' => $validated_data['description'],
                ],
            ],
            'id',
            ['name', 'description', 'date']);

        /****** Récupération des anciens contacts pour mettre à jour les implémentations ******/
        $old_contacts_ids = $jiri->contacts()->pluck('contact_id')->toArray();

        /****** Mise à jour des homeworks ******/
        if (!empty($validated_data['projects'])) {
            $jiri->projects()->sync($validated_data['projects']);
        } else {
            $jiri->projects()->detach();
        }

        /****** Mise à jour des attendances ******/
        if (!empty($validated_data['contacts'])) {
            $jiri->contacts()->sync($validated_data['contacts']);
        } else {
            $jiri->contacts()->detach();
        }

        /****** Implementation : Suppression d'un contact du jiri ******/
        $new_contacts_ids = array_keys($validated_data['contacts'] ?? []);
        $contacts_to_remove = array_diff($old_contacts_ids, $new_contacts_ids);

        if (!empty($contacts_to_remove)) {
            foreach ($contacts_to_remove as $contact_to_remove) {
                if ($contact = Contact::where('id', '=', $contact_to_remove)->first()) {
                    $contact->homeworks()->detach();
                }
            }
        }

        /****** Implementation : Changement de rôle d'un contact ******/
        if (!empty($validated_data['contacts'])) {
            foreach ($validated_data['contacts'] as $id => $contact) {
                $homeworks_id = $jiri->homeworks()->pluck('id');
                $correct_contact = $jiri->contacts->where('id', '=', $id)->first();

                if ($contact['role'] === ContactRoles::Evaluated->value) {
                    $correct_contact->homeworks()->sync($homeworks_id);
                } else {
                    $correct_contact->homeworks()->detach();
                }
            }
        }

        return redirect(route('jiris.show', $jiri->id));
    }
}
