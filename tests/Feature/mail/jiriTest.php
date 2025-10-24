<?php

use App\Events\JiriCreatedEvent;
use App\Models\Jiri;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

it("fires an event asking to queue an email to send to the author after the creation of a Jiri", function () {

    \Illuminate\Support\Facades\Event::fakeExcept('eloquent.created: App\Models\Jiri');
    // Fake tout les events sauf celui dans les parentheses

    $formData = Jiri::factory()->raw();

    $this->post(route('jiris.store'), $formData);
    $jiri = Jiri::first();

    Event::assertListening(
        JiriCreatedEvent::class,
        \App\Listeners\JiriCreatedNotificationsListener::class
    );
    Event::assertDispatched(JiriCreatedEvent::class);
});


it('fills correctly the email with the values of the created Jiri', function () {
    \Illuminate\Support\Facades\Mail::fake();

    Event::fake(['eloquent.created: App\Models\jiri']);

    $jiri = Jiri::factory()->for(User::factory())->create();

    $mail = new \App\Mail\JiriCreatedMail($jiri);

    $mail->assertSeeInHtml($jiri->name);
});


it('sends the email using the configured transport layer', function () {

    Event::fake(['eloquent.created: App\Models\Jiri']);

    \Illuminate\Support\Facades\Mail::fake();

    $user = User::factory()->create();
    $jiri = Jiri::factory()->for($user)->create();

    try {
        Mail::to($user)->send(new \App\Mail\JiriCreatedMail($jiri));
    } catch (Exception $e) {
        test()->fail($e->getMessage());
    }

    $response = file_get_contents('http://localhost:8025/api/v1/messages');
    $messages = json_decode($response, true);

    $this->assertNotEmpty($messages['messages']);
});


it('sends an email to the author after the creation of a jiri', function () {
    Mail::fake();

    $data = Jiri::factory()->for($this->user)->raw();

    $response = $this->post(route('jiris.store'), $data);

    \Illuminate\Support\Facades\Mail::assertQueued(\App\Mail\JiriCreatedMail::class);
});
