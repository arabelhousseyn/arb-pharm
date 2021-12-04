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
            'product_name' => $this->faker->text,
            'amount' => $this->faker->numberBetween(10,50),
            'mark' => $this->faker->text,
            'is_available' => $this->faker->boolean
        ];
    }
}
