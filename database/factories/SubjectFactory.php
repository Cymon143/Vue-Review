<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('[A-Za-z0-9]{5}'),
            'name' => $this->faker->word,
            'hour' => $this->faker->numberBetween(1,3),
            'level' =>  $this->faker->numberBetween(7,12),
            'status' => 'Active',
        ];
    }
}
