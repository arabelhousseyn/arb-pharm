<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RequestEstimateImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'request_estimate_id' => $this->faker->numberBetween(1,30),
            'path' => 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg'
        ];
    }
}
