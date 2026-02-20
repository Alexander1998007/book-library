<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'publisher' => $this->faker->company,
            'author' => $this->faker->name,
            'genre' => $this->faker->word,
            'book_publication' => $this->faker->date(),
            'amount_of_words' => $this->faker->numberBetween(10000, 200000),
            'book_price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
