<?php

it('can display the register form',
    function () {

        $response = $this->get(route('register'));

        $response->assertSeeInOrder(['Créer votre compte !', '<form', 'Nom d’utilisateur', 'Adresse e-mail', 'Mot de passe', '<button', 'Créer mon compte', false]);
    }
);
