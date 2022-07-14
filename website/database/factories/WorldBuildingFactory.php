<?php

namespace Database\Factories;

use App\Models\WorldBuilding;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorldBuildingFactory extends Factory
{
    protected $model = WorldBuilding::class;

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
            'max_level' => $this->faker->numberBetween(0, 30),
            'default_level' => $this->faker->numberBetween(0, 30),
        ];
    }
}
