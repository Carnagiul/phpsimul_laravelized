<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorldFactory extends Factory
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
            'description' => $this->faker->text,
            'register_at' => $this->faker->dateTime,
            'open_at' => $this->faker->dateTime,
            'close_at' => $this->faker->dateTime,
            //
        ];
    }
}
