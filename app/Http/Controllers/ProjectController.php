<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Homework;
use App\Models\Implementation;
use App\Models\Jiri;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->paginate(5);

        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        $validated_data = request()->validate([
            'name' => 'required',
            'jiris.*' => 'nullable|integer|exists:jiris,id'
        ]);

        /****** Création du projet ******/
        $project = auth()->user()->projects()->create($validated_data);

        /****** Mise à jour des homeworks ******/
        if (!empty($validated_data['jiris'])) {
            foreach ($validated_data['jiris'] as $jiri) {
                $correct_jiri = Jiri::where('id', $jiri)->first();
                $correct_jiri?->projects()->attach($project);

                /****** Mise à jour des implementations ******/
                $homeworksID = Homework::where('project_id', $project->id)->get();
                $contacts = $correct_jiri->contacts()->get();

                foreach ($contacts as $contact) {
                    $attendance = Attendance::where('contact_id', $contact->id)->where('jiri_id', $jiri)->pluck('role')->first();

                    if ($attendance === ContactRoles::Evaluated->value) {
                        $contact->homeworks()->syncWithoutDetaching($homeworksID);
                    }
                }
            }
        }

        return redirect(route('projects.show', $project->id));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        $jiris = auth()->user()->jiris;

        return view('projects.create', compact('jiris'));
    }
}
