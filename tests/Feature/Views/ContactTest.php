<?php

use App\Models\Contact;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function (){
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('displays a complete list of contacts on the contact index page', function () {
    // Arrange
    $contacts = Contact::factory(4)
        ->for($this->user)
        ->create();

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

it('verifies if you can access to contacts.show view', function () {
    $contact = Contact::factory()
        ->for($this->user)
        ->create();

    $response = $this->get(route('contacts.show', $contact->id));

    $response->assertStatus(200);
    $response->assertViewIs('contacts.show');
    $response->assertSeeInOrder([$contact->name, $contact->email]);
});
