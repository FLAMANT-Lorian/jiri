<?php

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Implementation;
use App\Models\Jiri;
use App\Models\Project;
use Carbon\Carbon;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function (){
    $user = User::factory()->create();

    actingAs($user);
});
it('creates successfully a jiri from the data provided by the request', function () {
    // Arrange
    $jiri = Jiri::factory()->raw();

    // Act
    $response = $this->post(route('jiris.store'), $jiri);

    // Assert
    assertDatabaseHas('jiris',
        [
            'name' => $jiri['name'],
        ]);
});

it('fails to create a new jiri in database when there the name is missing in the request', function () {
    $jiri = Jiri::factory()
        ->withoutName()
        ->raw();

    $response = $this->post(route('jiris.store'), $jiri);

    $response->assertInvalid('name');
    assertDatabaseEmpty('jiris');
});

it('fails to create a new jiri in database when there the date is missing in the request', function () {
    $jiri = Jiri::factory()
        ->withoutDate()
        ->raw();

    $response = $this->post(route('jiris.store'), $jiri);

    $response->assertInvalid('date');
    assertDatabaseEmpty('jiris');
});

it('fails to create a new jiri in database when there the date is incorrect in the request', function () {
    $jiri = Jiri::factory()
        ->withInvalidDate()
        ->raw();

    $response = $this->post(route('jiris.store'), $jiri);

    $response->assertInvalid('date');
    assertDatabaseEmpty('jiris');
});

it('displays a complete list of jiries on the jiri index page', function () {
    // Arrange
    $jiris = Jiri::factory(4)->create();

    // Act
    $response = $this->get('/jiris');

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('jiris.index');
    $response->assertSee('<h1>Jiris disponible</h1>', false);

    foreach ($jiris as $jiri) {
        $response->assertSee($jiri->name, false);
    }
});

it('verifies if there are no jiris and displays an error message', function () {
    // Act
    $response = $this->get('/jiris');

    // Assert
    $response->assertSee('<h1>Il n’y a pas de jiri disponible</h1>', false);
});

it('verifies if the informations of every jiris are correct in the details views', function () {
    // Arrange
    $jiri = Jiri::factory()->create();

    // Act
    $response = $this->get('/jiris/' . $jiri->id);

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('jiris.show');
    $response->assertSee('<h1>Récapitulatif du jiri : ' . $jiri->name . '</h1>', false);
});

it('verifies if you give a false value to a specific column in the table', function () {
    $jiri = [
        'name' => '',
        'date' => Carbon::now(),
    ];

    $response = $this->post('/jiris', $jiri);

    $response->assertInvalid('name');
});

it('verifies if jiri data is correctly inserted in the database when you create a jiri with contacts and projects', function () {
    $jiri = Jiri::factory()->raw();

    $contacts = Contact::factory()
        ->count(3)
        ->create()
        ->pluck('id', 'id')
        ->toArray();

    $projects = Project::factory()
        ->count(3)
        ->create()
        ->pluck('id', 'id')
        ->toArray();

    $final_data = array_merge($jiri, [
        'projects' => $projects,
        'contacts' => $contacts,
    ]);


    $available_roles = [
        1 => ContactRoles::Evaluated->value,
        2 => ContactRoles::Evaluated->value,
    ];

    foreach ($contacts as $key => $contact) {
        $final_data['contacts'][$key] = array('role' => $available_roles[rand(1, 2)]);
    }

    $response = $this->post(route('jiris.store'), $final_data);

    expect(Jiri::all()->count())->toBe(1)
        ->and(Homework::all()->count())->toBe(3)
        ->and(Attendance::all()->count())->toBe(3)
        ->and(Implementation::all()->count())->toBe(9);
});
