<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

describe('Authenticated User ONLY', function () {
    beforeEach(function () {
        $user = User::factory()->create();
        actingAs($user);
    });

    it('verifies if a an authenticate user can’t go to login route and redirect to jiri.index route',
        function () {
            $response = $this->get(route('login'));

            $response->assertStatus(302);
            $response->assertRedirect(route('jiris.index'));
        });
});
