<?php

namespace Database\Factories;

use App\Models\Jiri;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class JiriFactory extends Factory
{
    protected $model = Jiri::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'date' => Carbon::now(),
            'description' => $this->faker->optional()->text(),
            'user_id' => rand(1, count(User::all())),
        ];
    }

    public function withoutName(): JiriFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => null,
            ];
        });
    }

    public function withoutDate(): JiriFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'date' => null,
            ];
        });
    }

    public function withInvalidDate(): JiriFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'date' => 'Je ne suis pas une date',
            ];
        });
    }
}
