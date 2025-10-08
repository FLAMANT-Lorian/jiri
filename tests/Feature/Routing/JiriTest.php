<?php

use App\Models\Jiri;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\actingAs;

beforeEach(function (){
    $user = User::factory()->create();

    actingAs($user);
});

it('redirects to the jiri index route after the successful creation of a jiri',
    function () {
        // Arrange
        $jiri = Jiri::factory()->raw();

        // Act
        $response = $this->post(route('jiris.store'), $jiri);

        // Assert
        $response->assertStatus(302);
        $response->assertRedirect(route('jiris.index'));
    }
);

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
    $response = $this->get('/jiris');

    // Assert
    $response->assertSee('<h1>Il n’y a pas de jiri disponible</h1>', false);
});

it('verifies if the informations of every jiris are correct in the details views', function () {
    // Arrange
    $jiri = Jiri::factory()->create();

    // Act
    $response = $this->get('/jiris/'.$jiri->id);

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('jiris.show');
    $response->assertSee('<h1>Récapitulatif du jiri : '.$jiri->name.'</h1>', false);
});

it('verifies if you give a false value to a specific column in the table', function () {
    $jiri = [
        'name' => '',
        'date' => Carbon::now(),
    ];

    $response = $this->post('/jiris', $jiri);

    $response->assertInvalid('name');
});
