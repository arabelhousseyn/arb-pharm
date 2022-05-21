<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique()->numberBetween(1,10),
            'commercial_name' => $this->faker->name,
            'num_rc' => $this->faker->numberBetween(100,1000),
            'nif' => $this->faker->text(5),
            'nis' => $this->faker->text(5),
            'num_ar' => $this->faker->numberBetween(100,1000),
            'social_name' => $this->faker->name,
            'social_place' => $this->faker->name,
            'activity_code' => $this->faker->postcode
        ];
    }
}
