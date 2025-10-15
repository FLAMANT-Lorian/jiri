<?php

use App\Models\Contact;
use App\Models\Jiri;
use App\Models\User;
use function Pest\Laravel\actingAs;

describe('Authenticated User ONLY', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        actingAs($this->user);
    });

    it('verifies if a an authenticate user can’t go to login route and redirect to jiri.index route',
        function () {
            $response = $this->get(route('login'));

            $response->assertStatus(302);
            $response->assertRedirect(route('jiris.index'));
        }
    );
});

it('verifies if an authenticate user can’t modify a jiri of another user',
    function () {
        $user = User::factory()->create();

        $jiri = Jiri::factory()
            ->for($user)->create();

        $other_user = User::factory()
            ->create();

        actingAs($other_user);

        $response = $this->patch(route('jiris.update', $jiri));

        $response->assertStatus(403);
    }
);

it('verifies if an authenticate user can’t modify a contact of another user',
    function () {
        $user = User::factory()->create();

        $contact = Contact::factory()
            ->for($user)
            ->create();

        $other_user = User::factory()->create();
        actingAs($other_user);

        $response = $this->patch(route('contacts.update', $contact));

        $response->assertStatus(403);
    }
);
