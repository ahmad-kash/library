<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\books>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->words(3, true),
            'language' => fake()->languageCode(),
            'author_id' => Author::inRandomOrder()->first('id')->id,
            'publisher_id' => Publisher::inRandomOrder()->first('id')->id,
            'category_id' => Category::inRandomOrder()->first('id')->id,
            'number_of_pages' => fake()->numberBetween(10, 200),
            'selling_price' => fake()->numberBetween(10, 100),
            'renting_price' => fake()->numberBetween(1, 5),
            'number_of_available_books' => fake()->numberBetween(10, 500),
            'cover_photo_url' => '/images/clean_code.jpg',
        ];
    }
}
