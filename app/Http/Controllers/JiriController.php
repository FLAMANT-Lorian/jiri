<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Http\Requests\SaveJiriRequest;
use App\Mail\JiriCreatedMail;
use App\Models\Contact;
use App\Models\Jiri;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;

class JiriController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $jiris = Jiri::with(['attendances', 'projects', 'user'])
            ->where('user_id', '=', Auth::user()->id)
            ->simplePaginate(5);

        return view('jiris.index', compact('jiris'));
    }

    public function store(SaveJiriRequest $request): RedirectResponse
    {
        $validated_data = $request->validated();

        $jiri = Auth::user()->jiris()->create($validated_data);

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

        return redirect(route('jiris.show', $jiri->id));
    }

    public function show(Jiri $jiri)
    {
        $jiri->load([
            'contacts',
            'attendances',
            'projects',
        ]);

        return view('jiris.show', compact('jiri'));
    }

    public function create()
    {
        $contacts = Auth::user()->contacts;
        $projects = Auth::user()->projects;

        return view('jiris.create', compact('contacts', 'projects'));
    }

    public function edit(Jiri $jiri)
    {
        // Récupérer les données du jiri
        $contacts = Auth::user()->contacts;
        $projects = Auth::user()->projects;

        return view('jiris.edit', compact('jiri', 'contacts', 'projects'));
    }

    public function update(SaveJiriRequest $request, Jiri $jiri): RedirectResponse
    {
        $this->authorize('update', $jiri);

        /****** Validation des données ******/
        $validated_data = $request->validated();

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
