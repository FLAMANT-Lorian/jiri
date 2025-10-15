<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

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

        Auth::user()->projects()->create($validated_data);

        return redirect(route('projects.index'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}
