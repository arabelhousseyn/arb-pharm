<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Admin, User, Product, ProductImages, RequestEstimate, RequestEstimateImage, ProductUser, UserProfile};
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Admin::factory(10)->create();
        UserProfile::factory(10)->create();
        Product::factory(10)->create();
        ProductImages::factory(30)->create();
        RequestEstimate::factory(30)->create();
        RequestEstimateImage::factory(30)->create();
        ProductUser::factory(30)->create();
    }
}
