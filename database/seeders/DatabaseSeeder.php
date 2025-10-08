<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Password;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Pour tester la connection (login)
       /* User::factory()->create([
           'name' => 'Flamant Ambre',
           'email' => 'ambre.flamant30@gmail.com',
            'password' => password_hash('VictoriaLorian', PASSWORD_BCRYPT),
        ]);*/

        // Pour tester lors de la création d'un jiri
       /* Contact::factory()->count(4)->create();
        Project::insert([
            [
                'name' => 'Portfolio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CV',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Client',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'PFE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Projet Web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Flutter',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);*/

        // Pour tester lors de la création d'un contact
        /*Jiri::factory()
            ->hasAttached(
                Project::factory()->count(4)->create()
            )
        ->count(3)
        ->create();*/
    }
}
