<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserActivityCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' =>$this->faker->numberBetween(1,10),
            'code' => $this->faker->numberBetween(100,1000),
        ];
    }
}
