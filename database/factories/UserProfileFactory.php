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
            'user_id' => $this->faker->numberBetween(1,10),
            'commercial_name' => $this->faker->name,
            'num_rc' => $this->faker->numberBetween(100,1000),
            'nif' => $this->faker->text(5),
            'nis' => $this->faker->text(5),
            'num_ar' => $this->faker->numberBetween(100,1000),
            'pro_card' => $this->faker->text(5),
            'adress' => $this->faker->address,
        ];
    }
}
