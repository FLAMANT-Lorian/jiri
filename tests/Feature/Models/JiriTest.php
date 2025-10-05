<?php

use App\Enums\ContactRoles;
use App\Models\Attendance;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Implementation;
use App\Models\Jiri;
use App\Models\Project;

it('is possible to retrieve many evaluated and many evaluators from a jiri', function () {
    $jiri = Jiri::factory()
        ->hasAttached(
            Contact::factory()->count(7),
            ['role' => ContactRoles::Evaluated->value]
        )
        ->hasAttached(
            Contact::factory()->count(3),
            ['role' => ContactRoles::Evaluators->value]
        )
        ->create();

    $this->assertDatabaseCount('attendances', 10);
    expect($jiri->evaluators->count())->toBe(3)
        ->and($jiri->evaluated->count())->toBe(7)
        ->and($jiri->contacts->count())->toBe(10)
        ->and($jiri->attendances->count())->toBe(10);
});

it('is possible to retrieve many projects from a jiri', function () {
    $jiri = Jiri::factory()
        ->hasAttached(
            Project::factory()->count(3)
        )
        ->create();

    $this->assertDatabaseCount('homeworks', 3);
    expect($jiri->projects->count())->toBe(3);
});

it('is possible to retrieve many homeworks from a evaluated', function () {
    $jiri = Jiri::factory()
        ->hasAttached(
            Project::factory()->count(3)
        )
        ->hasAttached(
            Contact::factory()->count(1),
            ['role' => ContactRoles::Evaluated->value]
        )
        ->create();

    $contact = $jiri->evaluated()->first();
    $homeworks = $jiri->homeworks;

    foreach ($homeworks as $homework) {
        $contact->homeworks()->attach($homework->id);
    }

    expect($jiri->homeworks->count())->toBe(3)
        ->and($contact->homeworks->count())->toBe(3)
        ->and($contact->implementations->count())->toBe(3);

    foreach ($homeworks as $homework) {
        expect($homework->implementations->count())->toBe(1);
    }

});
