<?php

use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (){
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('creates a project and redirects to the project index', function () {
    // Arrange
    $project = Project::factory()
        ->make()
        ->toArray();

    // Act
    $response = $this->post(route('projects.store'), $project);

    // Assert
    $response->assertStatus(302);
    $response->assertRedirect(route('projects.index'));
    assertDatabaseHas('projects',
        [
            'name' => $project['name'],
        ]);
});

it('verifies if you give a false value to a specific column in the table', function () {
    $project = [
        'name' => '',
    ];

    $response = $this->post('/projects', $project);

    $response->assertInvalid('name');
});
