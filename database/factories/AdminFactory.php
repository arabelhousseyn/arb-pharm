<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Hash;
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fname' => $this->faker->firstNameMale,
            'lname' => $this->faker->lastName,
            'email' => $this->faker->email,
            'username' => $this->faker->userName,
            'phone' => $this->faker->phoneNumber,
            'password' => Hash::make('password')
        ];
    }
}
