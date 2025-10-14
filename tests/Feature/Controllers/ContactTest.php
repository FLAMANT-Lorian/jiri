<?php

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Implementation;
use App\Models\Jiri;
use App\Models\Project;
use function Pest\Laravel\assertDatabaseHas;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function (){
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('verifies if you give a false value to a specific column in the table', function () {
    $contact = [
        'name' => '',
        'email' => 'test.be',
    ];

    $response = $this->post('/contacts', $contact);

    $response->assertInvalid(['name', 'email']);
});

it('creates a contact and redirects to the contact index', function () {
    // Arrange
    $contact = Contact::factory()->make()->toArray();

    // Act
    $response = $this->post('/contacts', $contact);

    // Assert
    $response->assertStatus(302);
    $response->assertRedirect('/contacts');
    assertDatabaseHas('contacts',
        [
            'name' => $contact['name'],
            'email' => $contact['email'],
        ]);
});

it('verifies if a contact is correctly inserted in the database when you create a contact associate to a jiri', function () {
    $contact = Contact::factory()->raw();

    $jiris = Jiri::factory()
        ->hasAttached(
            Project::factory()->count(3)->create()
        )
        ->count(3)
        ->for($this->user)
        ->create()
        ->pluck('id', 'id')
        ->toArray();

    $jiri_to_insert = [];
    foreach ($jiris as $jiri_id => $jiri) {
        $homeworks = Homework::where('jiri_id', '=', $jiri_id)->pluck('id', 'id');
        $jiri_to_insert[$jiri_id]['role'] = ContactRoles::Evaluated->value;

        foreach ($homeworks as $homework_id) {
            $jiri_to_insert[$jiri_id]['homeworks'][] = $homework_id;
        }
    }

    $final_data = array_merge($contact, ['jiris' => $jiri_to_insert]);

    $response = $this->post(route('contacts.store'), $final_data);

    expect(Contact::all()->count())->toBe(1)
        ->and(Attendance::all()->count())->toBe(3)
        ->and(Implementation::all()->count())->toBe(9);
});
