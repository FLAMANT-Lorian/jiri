<?php

use App\Models\Contact;

it('displays a complete list of contacts on the contact index page', function () {
    // Arrange
    $contacts = Contact::factory(4)->create();

    // Act
    $response = $this->get('/contacts');

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('contacts.index');
    $response->assertSee('<h1>Contacts disponibles</h1>', false);

    foreach ($contacts as $contact) {
        $response->assertSee($contact->name, false);
    }
});

it('verifies if there are no contact and displays an error message', function () {
    // Act
    $response = $this->get('/contacts');

    // Assert
    $response->assertSee('<h1>Il n’y a pas de contact disponible</h1>', false);
});

it('verifies that the contacts.create route displays a form to create a contact', function (string $locale, string $main_heading) {
    App::setLocale($locale);

    $response = $this->get(route('contacts.create'));

    $response->assertStatus(200);
    $response->assertViewIs('contacts.create');
    $response->assertSee("<h1>$main_heading</h1>", false);
})->with(
    [
        ['fr', 'Créez un contact'],
        ['en', 'Create a contact'],
    ]
);
