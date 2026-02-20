<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_book_using_factory()
    {
        $book = Book::factory()->create([
            'book_publication' => '2023-01-01',
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $book->title,
        ]);

        // Перевірка дати через формат
        $this->assertEquals('2023-01-01', $book->book_publication->format('Y-m-d'));
    }

    /** @test */
    public function fillable_fields_are_mass_assignable()
    {
        $data = [
            'title' => 'Test Title',
            'publisher' => 'Test Publisher',
            'author' => 'Test Author',
            'genre' => 'Fiction',
            'book_publication' => '2023-01-01',
            'amount_of_words' => 5000,
            'book_price' => 15.50,
        ];

        $book = Book::create($data);

        foreach ($data as $key => $value) {
            if ($key === 'book_publication') {
                // для дати перевіряємо через формат Carbon
                $this->assertEquals($value, $book->$key->format('Y-m-d'));
            } else {
                $this->assertEquals($value, $book->$key);
            }
        }
    }
}
