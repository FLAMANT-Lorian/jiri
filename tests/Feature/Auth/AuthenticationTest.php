<?php

use App\Models\Jiri;
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

it('verifies if an authenticate user can’t acces to jiris.edit route of another user',
    function () {
        User::factory()->create();

        $jiri = Jiri::factory()->create([
            'user_id' => 1,
        ]);

        $other_user = User::factory()
            ->create();

        actingAs($other_user);

        $response = $this->patch(route('jiris.update', $jiri));

        $response->assertStatus(403);
    });
