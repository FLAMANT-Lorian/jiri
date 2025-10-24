<?php

use App\Enums\ContactRoles;
use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();

    actingAs($this->user);
});

it('is possible to retrieve many evaluated and many evaluators from a jiri',
    function () {
        Event::fake('eloquent.created: App\Models\Jiri');

        $contact1 = Contact::factory()
            ->count(7)
            ->for($this->user)
            ->create();

        $contact2 = Contact::factory()
            ->count(3)
            ->for($this->user)
            ->create();

        $jiri = Jiri::factory()
            ->hasAttached(
                $contact1,
                ['role' => ContactRoles::Evaluated->value]
            )
            ->hasAttached(
                $contact2,
                ['role' => ContactRoles::Evaluators->value]
            )
            ->for($this->user)
            ->create();

        $this->assertDatabaseCount('attendances', 10);
        expect($jiri->evaluators->count())->toBe(3)
            ->and($jiri->evaluated->count())->toBe(7)
            ->and($jiri->contacts->count())->toBe(10)
            ->and($jiri->attendances->count())->toBe(10);
    }
);

it('is possible to retrieve many projects from a jiri',
    function () {
        Event::fake('eloquent.created: App\Models\Jiri');

        $projects = Project::factory()
            ->count(3)
            ->for($this->user)
            ->create();

        $jiri = Jiri::factory()
            ->hasAttached(
                $projects
            )
            ->for($this->user)
            ->create();

        $this->assertDatabaseCount('homeworks', 3);
        expect($jiri->projects->count())->toBe(3);
    }
);

it('is possible to retrieve many homeworks from a evaluated',
    function () {
        Event::fake('eloquent.created: App\Models\Jiri');

        $projects = Project::factory()
            ->count(3)
            ->for($this->user)
            ->create();

        $contacts = Contact::factory()
            ->for($this->user)
            ->create();

        $jiri = Jiri::factory()
            ->hasAttached(
                $projects
            )
            ->hasAttached(
                $contacts,
                ['role' => ContactRoles::Evaluated->value]
            )
            ->for($this->user)
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
    }
);
