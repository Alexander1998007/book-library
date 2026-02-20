<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        // Додаємо токен для middleware
        $this->headers = [
            'Authorization' => 'Bearer ' . env('API_TOKEN', 'supersecretapitoken123'),
            'Accept' => 'application/json',
        ];
    }

    /** @test */
    public function it_can_get_all_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/book', $this->headers);

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function it_can_get_single_book()
    {
        $book = Book::factory()->create([
            'book_publication' => '2023-01-01',
        ]);

        $response = $this->getJson("/api/book/{$book->id}", $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $book->id,
                'title' => $book->title,
            ]);

        // Перевірка дати через формат
        $this->assertEquals('2023-01-01', $book->book_publication->format('Y-m-d'));
    }

    /** @test */
    public function it_returns_404_if_book_not_found()
    {
        $response = $this->getJson('/api/book/999', $this->headers);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Book not found']);
    }

    /** @test */
    public function it_can_create_book()
    {
        $payload = [
            'title' => 'Test Book',
            'publisher' => 'Test Publisher',
            'author' => 'Test Author',
            'genre' => 'Fiction',
            'book_publication' => '2023-01-01',
            'amount_of_words' => 1000,
            'book_price' => 9.99,
        ];

        $response = $this->postJson('/api/book', $payload, $this->headers);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Test Book']);

        $book = Book::first();
        $this->assertEquals('2023-01-01', $book->book_publication->format('Y-m-d'));
        $this->assertDatabaseHas('books', ['title' => 'Test Book']);
    }

    /** @test */
    public function it_can_update_book()
    {
        $book = Book::factory()->create([
            'title' => 'Old Title',
            'book_publication' => '2023-01-01',
        ]);

        $payload = [
            'title' => 'Updated Title',
            'book_publication' => '2024-05-10',
        ];

        $response = $this->patchJson("/api/book/{$book->id}", $payload, $this->headers);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title']);

        $book->refresh();
        $this->assertEquals('Updated Title', $book->title);
        $this->assertEquals('2024-05-10', $book->book_publication->format('Y-m-d'));
    }

    /** @test */
    public function it_can_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/book/{$book->id}", [], $this->headers);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
