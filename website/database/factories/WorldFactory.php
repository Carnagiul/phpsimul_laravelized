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
            'name' => 'fake World',
            'description' => 'fake World description',
            'register_at' => now()->subDays(10),
            'open_at' => now()->addDays(10),
            'close_at' => now()->addDays(100),
            //
        ];
    }
}
