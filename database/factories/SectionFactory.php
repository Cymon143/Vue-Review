<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'adviser_user_id' => 1,
            'code' => $this->faker->regexify('[A-Za-z0-9]{5}'),
            'name' => $this->faker->word,
            'level' =>  $this->faker->numberBetween(7,12),
        ];
    }
}
