<?php

use App\Models\Project;

it('creates a project and redirects to the project index', function () {
    // Arrange
    $project = Project::factory()->make()->toArray();

    // Act
    $response = $this->post('/projects', $project);

    // Assert
    $response->assertStatus(302);
    $response->assertRedirect('/projects');
    \Pest\Laravel\assertDatabaseHas('projects',
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
