<?php

use App\Models\Jiri;

it('verifies that the jiris.create route displays a form to create a jiri', function (string $locale, string $main_heading) {
    App::setLocale($locale);

    $response = $this->get(route('jiris.create'));

    $response->assertStatus(200);
    $response->assertViewIs('jiris.create');
    $response->assertSee("<h1>$main_heading</h1>", false);
})->with([
    ['fr', 'Créez un jiri'],
    ['en', 'Create a jiri'],
]);

