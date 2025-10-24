<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        $validated_data = request()->validate([
            'name' => 'required',
        ]);


        $project = auth()->user()->projects()->create($validated_data);

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
