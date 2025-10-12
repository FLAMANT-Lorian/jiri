<?php

it('verifies if reset password view displays a form to reset your password',
    function () {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
        $response->assertSee('Mot de passe oublié ?');
    }
);
