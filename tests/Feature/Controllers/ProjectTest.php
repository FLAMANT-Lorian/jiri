<?php

use App\Enums\ContactRoles;
use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('creates a project and redirects to the project index',
    function () {
        // Arrange
        $project = Project::factory()
            ->make()
            ->toArray();

        // Act
        $response = $this->post(route('projects.store'), $project);

        // Assert
        $response->assertStatus(302);
        $project = Project::first();
        $response->assertRedirect(route('projects.show', $project->id));
        assertDatabaseHas('projects',
            [
                'name' => $project['name'],
            ]);
    }
);

it('verifies if you give a false value to a specific column in the table',
    function () {
        $project = [
            'name' => '',
        ];

        $response = $this->post('/projects', $project);

        $response->assertInvalid('name');
    }
);


it('verifies if you are redirected to projects.show route after created a project associate to a jiri',
    function () {
        Event::fake('eloquent.created: App\Models\Jiri');

        $project = Project::factory()->raw();

        $contact = Contact::factory()->for($this->user)->create();
        $projectDB = Project::factory()->for($this->user)->create();

        $jiri = Jiri::factory()
            ->hasAttached(
                $contact,
                ['role' => \App\Enums\ContactRoles::Evaluated->value])
            ->hasAttached($projectDB)
            ->afterCreating(function (Jiri $jiri) {
                $evaluated_contacts = $jiri->contacts()->wherePivot('role', '=', ContactRoles::Evaluated->value)->get();
                $homeworks = $jiri->homeworks()->pluck('id');
                if ($evaluated_contacts) {
                    foreach ($evaluated_contacts as $contact) {
                        foreach ($homeworks as $homework_id) {
                            $contact->homeworks()->attach($homework_id);
                        }
                    }
                }
            })
            ->for($this->user)
            ->create()
            ->pluck('id')
        ->toArray();

        $data = array_merge($project, ['jiris' => $jiri]);

        $response = $this->post(route('projects.store'), $data);

        assertDatabaseHas('projects', [
            'name' => $data['name']
        ]);

        assertDatabaseCount('homeworks', 2);

        assertDatabaseCount('implementations', 2);
    });
