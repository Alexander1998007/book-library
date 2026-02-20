<?php

namespace App\Models;

use OpenApi\Attributes as OA;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[OA\Schema(
    schema: "Book",
    required: [
        "title",
        "publisher",
        "author",
        "genre",
        "book_publication",
        "amount_of_words",
        "book_price"
    ],
    type: "object"
)]
class Book extends Model
{
    use HasFactory;

    // OpenAPI Properties для Swagger (для документації)
    #[OA\Property(readOnly: true)]
    protected ?int $id = null;

    #[OA\Property(description: "Назва книги")]
    protected ?string $title = null;

    #[OA\Property(description: "Видавець книги")]
    protected ?string $publisher = null;

    #[OA\Property(description: "Автор книги")]
    protected ?string $author = null;

    #[OA\Property(description: "Жанр книги")]
    protected ?string $genre = null;

    #[OA\Property(format: "date")]
    protected ?string $book_publication = null;

    #[OA\Property]
    protected ?int $amount_of_words = null;

    #[OA\Property(format: "float")]
    protected ?float $book_price = null;

    // Атрибути, які можна масово присвоювати
    protected $fillable = [
        'title',
        'publisher',
        'author',
        'genre',
        'book_publication',
        'amount_of_words',
        'book_price',
    ];

    // Приведення типів
    protected $casts = [
        'book_publication' => 'date',
        'book_price' => 'float',
        'amount_of_words' => 'integer',
    ];
}
