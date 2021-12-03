<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 11,
            'description' => $this->faker->realText,
            'technical_sheet_pdf' => 'https://arb.arbpharm.com/storage/app/public/technical_sheet/61a4a80a84cf7.pdf'
        ];
    }
}
