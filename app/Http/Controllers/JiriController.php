<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Implementation;
use App\Models\Jiri;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class JiriController extends Controller
{
    public function index()
    {
        $jiris = Jiri::all();

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

        $jiri = Jiri::create($validated_data);

        if (!empty($validated_data['projects'])) {
            $jiri->projects()->attach($validated_data['projects']);
        }

        if (!empty($validated_data['contacts'])) {
            foreach ($validated_data['contacts'] as $id => $contact) {
                $jiri->contacts()->attach($id, ['role' => $contact['role']]);

                if ($contact['role'] === ContactRoles::Evaluated->value) {
                    $correct_contact = Contact::where('id', '=', $id)->first();
                    $homeworks = Homework::where('jiri_id', '=', $jiri->id)->pluck('id');
                    $correct_contact->homeworks()->attach($homeworks);
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
}
