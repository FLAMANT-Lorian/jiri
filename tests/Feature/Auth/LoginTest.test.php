<?php

use App\Models\User;

it('can display the login form', function () {

    $response = $this->get(route('login'));

    $response->assertSeeInOrder(['Connection à l’espace Jiri', '<form', 'Adresse e-mail', 'Mot de passe', '<button', 'Se connecter', false]);
});

it('verifies if you are redirected to the dashboard after a successful request',
    function () {
        $password = '123';
        $user = User::factory()->create([
            'name' => 'Flamant Ambre',
            'email' => 'ambre.flamant30@gmail.com',
            'password' => Hash::make($password),
        ]);

        $response = $this->post(route('login.store'),
            [
                'email' => $user->email,
                'password' => $password

            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('jiris.index'));
    }
);
