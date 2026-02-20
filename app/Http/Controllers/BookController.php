<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

#[OA\Tag(
    name: "Books",
    description: "API для роботи з книгами"
)]
class BookController extends Controller
{
    #[OA\Get(
        path: "/api/book",
        summary: "Отримати список всіх книг",
        security: [["bearerAuth" => []]],
        tags: ["Books"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список книг",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Book")
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        return response()->json(Book::all());
    }

    #[OA\Get(
        path: "/api/book/{id}",
        summary: "Отримати одну книгу за ID",
        security: [["bearerAuth" => []]],
        tags: ["Books"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID книги",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Книга знайдена",
                content: new OA\JsonContent(ref: "#/components/schemas/Book")
            ),
            new OA\Response(response: 404, description: "Книга не знайдена")
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    #[OA\Post(
        path: "/api/book",
        summary: "Додати нову книгу",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/Book")
        ),
        tags: ["Books"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Книга створена",
                content: new OA\JsonContent(ref: "#/components/schemas/Book")
            ),
            new OA\Response(response: 400, description: "Некоректні дані")
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'book_publication' => 'required|date',
            'amount_of_words' => 'required|integer',
            'book_price' => 'required|numeric',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201);
    }

    #[OA\Patch(
        path: "/api/book/{id}",
        summary: "Оновити інформацію про книгу",
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/Book")
        ),
        tags: ["Books"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID книги",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Книга оновлена",
                content: new OA\JsonContent(ref: "#/components/schemas/Book")
            ),
            new OA\Response(response: 404, description: "Книга не знайдена")
        ]
    )]
    public function update(Request $request, int $id): JsonResponse
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'publisher' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'genre' => 'sometimes|string|max:255',
            'book_publication' => 'sometimes|date',
            'amount_of_words' => 'sometimes|integer',
            'book_price' => 'sometimes|numeric',
        ]);

        $book->update($validated);
        return response()->json($book);
    }

    #[OA\Delete(
        path: "/api/book/{id}",
        summary: "Видалити книгу",
        security: [["bearerAuth" => []]],
        tags: ["Books"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID книги",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 204, description: "Книга видалена"),
            new OA\Response(response: 404, description: "Книга не знайдена")
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();
        return response()->json(null, 204);
    }
}
