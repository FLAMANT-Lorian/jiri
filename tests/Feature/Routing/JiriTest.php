<?php

use App\Models\Jiri;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\actingAs;

// GUEST
it('verifies if a guest can’t access to jiris.index route',
    function () {
        $response = $this->get(route('jiris.index'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
);

// AUTH
describe('Authenticated User ONLY', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        actingAs($this->user);
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

    it('displays a complete list of jiries on the jiri index page',
        function () {
            // Arrange
            $jiris = Jiri::factory(4)
                ->for($this->user)
                ->create();

            // Act
            $response = $this->get('/jiris');

            // Assert
            $response->assertStatus(200);
            $response->assertViewIs('jiris.index');
            $response->assertSee('Vos Jiris');

            foreach ($jiris as $jiri) {
                $response->assertSee($jiri->name);
            }
        }
    );

    it('verifies if there are no jiris and displays an error message',
        function () {
            $response = $this->get('/jiris');

            // Assert
            $response->assertSee('Il n’y a pas de jiri disponible');
        }
    );

    it('verifies if the informations of every jiris are correct in the details views',
        function () {
            // Arrange
            $jiri = Jiri::factory()
                ->for($this->user)
                ->create();

            // Act
            $response = $this->get(route('jiris.show', $jiri->id));

            // Assert
            $response->assertStatus(200);
            $response->assertViewIs('jiris.show');
            $response->assertSee('<h1>Récapitulatif du jiri : ' . $jiri->name . '</h1>', false);
        }
    );

    it('verifies if you give a false value to a specific column in the table',
        function () {
            $jiri = [
                'name' => '',
                'date' => Carbon::now(),
            ];

            $response = $this->post('/jiris', $jiri);

            $response->assertInvalid('name');
        }
    );
});
