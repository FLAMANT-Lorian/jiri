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

        User::factory()
            ->has(
                Jiri::factory()
                    ->hasAttached(
                        Project::factory()->count(4)
                    )
                    ->hasAttached(
                        Contact::factory()->count(4),
                        fn() => ['role' => $available_roles[rand(0, 1)]]
                    )
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
                    ->count(5)
            )
            ->create([
                'name' => 'Flamant Ambre',
                'email' => 'ambre.flamant30@gmail.com',
                'password' => password_hash('VictoriaLorian', PASSWORD_BCRYPT),
            ]);

        User::factory()
            ->has(
                Jiri::factory()
                    ->hasAttached(
                        Project::factory()->count(4)
                    )
                    ->hasAttached(
                        Contact::factory()->count(4),
                        fn() => ['role' => $available_roles[rand(0, 1)]]
                    )
                    ->afterCreating(function (Jiri $jiri) {
                        $evaluated_contacts = $jiri->contacts()->wherePivot('role', '=', ContactRoles::Evaluated->value)->get();
                        $homeworks = $jiri->homeworks()->pluck('id');

                        if ($evaluated_contacts) {
                            foreach ($evaluated_contacts as $contact) {
                                    $contact->homeworks()->attach($homeworks);
                            }
                        }
                    })
                    ->count(5)
            )
            ->create();
    }
}
