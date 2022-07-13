<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorldRessourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            //
        ];
    }
}
