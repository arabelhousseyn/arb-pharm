<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RequestEstimateFactory extends Factory
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
            'product_name' => $this->faker->name,
            'amount' => $this->faker->numberBetween(10,50),
            'mark' => 'none',
            'is_available' => $this->faker->boolean
        ];
    }
}
