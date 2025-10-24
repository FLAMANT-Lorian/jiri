<?php

use App\Models\Jiri;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('verifies that the jiris.create route displays a form to create a jiri',
    function (string $locale, string $main_heading) {
        App::setLocale($locale);

        $response = $this->get(route('jiris.create'));

        $response->assertStatus(200);
        $response->assertViewIs('jiris.create');
        $response->assertSee("$main_heading");
    })->with([
    ['fr', 'Créez un jiri'],
    ['en', 'Create a jiri'],
]);

it('verifies if the jiris in the dashboard page are associated to the current user',
    function () {
    Event::fake('eloquent.created: App\Models\Jiri');

        $user = User::factory()
            ->has(Jiri::factory()
                ->count(3))
            ->create();

        $other_user = User::factory()
            ->has(Jiri::factory()
                ->count(2))
            ->create();

        actingAs($user);

        $response = get(route('jiris.index'));

        $response->assertStatus(200);

        foreach ($user->jiris as $jiri) {
            $response->assertSee($jiri->name);
        }

        foreach ($other_user->jiris as $jiri) {
            $response->assertDontSee($jiri->name);
        }
    }
);

it('verifies if a jiri.edit route exist and displays a update form',
    function () {
        Event::fake('eloquent.created: App\Models\Jiri');

        $jiri = Jiri::factory()
            ->for($this->user)
            ->create();

        $response = $this->get(route('jiris.edit', $jiri->id));

        $response->assertStatus(200);
        $response->assertViewIs('jiris.edit');
        $response->assertSee('Modifier le jiri');
    }
);
