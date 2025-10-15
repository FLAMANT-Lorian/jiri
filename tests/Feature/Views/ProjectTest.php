<?php

use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function (){
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('verifies if there are no project and displays an error message', function () {
    // Act
    $response = $this->get('/projects');

    // Assert
    $response->assertSee('<h1>Il n’y a pas de projet disponible</h1>', false);
});

it('verifies if the informations of every project are correct in the project views', function () {
    $project = Project::factory()
        ->for($this->user)
        ->create();

    $response = $this->get('/projects/'.$project->id);

    $response->assertStatus(200);
    $response->assertViewIs('projects.show');
    $response->assertSee('<h1>Projet : '.$project->name.'</h1>', false);
});

it('displays a complete list of projects on the project index page', function () {
    // Arrange
    $projects = Project::factory(4)
        ->for($this->user)
        ->create();

    // Act
    $response = $this->get('/projects');

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('projects.index');
    $response->assertSee('<h1>Projets disponibles</h1>', false);

    foreach ($projects as $project) {
        $response->assertSee($project->name, false);
    }
});
