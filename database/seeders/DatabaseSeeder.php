<?php

namespace Database\Seeders;

use App\Enums\ContactRoles;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Jiri;
use App\Models\Project;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $available_roles = [
            0 => ContactRoles::Evaluated->value,
            1 => ContactRoles::Evaluators->value,
        ];

        $user1 = User::factory()->create([
            'name' => 'Flamant Lorian',
            'email' => 'lorian.flamant05@gmail.com',
            'password' => password_hash('Lorian', PASSWORD_BCRYPT),
        ]);

        $contacts1 = Contact::factory()
            ->count(4)
            ->for($user1)
            ->create();

        $projects1 = Project::factory()
            ->count(4)
            ->for($user1)
            ->create();

        Jiri::factory()
            ->count(4)
            ->hasAttached($contacts1,
                fn() => ['role' => $available_roles[rand(0, 1)]])
            ->hasAttached($projects1)
            ->afterCreating(function (Jiri $jiri) {
                $evaluated_contacts = $jiri->contacts()->wherePivot('role', '=', ContactRoles::Evaluated->value)->get();
                $homeworks = $jiri->homeworks()->pluck('id');

                if ($evaluated_contacts) {
                    foreach ($evaluated_contacts as $contact) {
                        foreach ($homeworks as $homework_id) {
                            $contact->homeworks()->attach($homework_id);
                        }
                    }
                }
            })
            ->for($user1)
            ->create();

        $user2 = User::factory()->create();

        $contacts2 = Contact::factory()
            ->count(4)
            ->for($user2)
            ->create();

        $projects2 = Project::factory()
            ->count(4)
            ->for($user2)
            ->create();

        Jiri::factory()
            ->count(4)
            ->hasAttached($contacts2,
                fn() => ['role' => $available_roles[rand(0, 1)]])
            ->hasAttached($projects2)
            ->afterCreating(function (Jiri $jiri) {
                $evaluated_contacts = $jiri->contacts()->wherePivot('role', '=', ContactRoles::Evaluated->value)->get();
                $homeworks = $jiri->homeworks()->pluck('id');

                if ($evaluated_contacts) {
                    foreach ($evaluated_contacts as $contact) {
                        foreach ($homeworks as $homework_id) {
                            $contact->homeworks()->attach($homework_id);
                        }
                    }
                }
            })
            ->for($user2)
            ->create();
    }
}
