<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = max(1, (int) $request->input('per_page', 12));

        $books = QueryBuilder::for(Book::class)
            ->allowedIncludes('author', 'category')
            ->allowedFilters(
                AllowedFilter::partial('title'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('author_id'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::callback('search', fn ($query, $value) => $query
                    ->where('title', 'like', "%{$value}%")
                    ->orWhereHas('author', fn ($query) => $query->where('name', 'like', "%{$value}%"))
                    ->orWhereHas('category', fn ($query) => $query->where('name', 'like', "%{$value}%")))
            )
            ->allowedSorts('id', 'title', 'price', 'published_date')
            ->defaultSort('title')
            ->with(['author', 'category'])
            ->paginate($perPage)
            ->appends($request->query());

        return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'required|string|unique:books',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'published_date' => 'required|date',
        ]);

        $book = Book::create($validated);

        return response()->json($this->normalizeBookPayload($book->load(['author', 'category'])), 201);
    }

    private function normalizeBookPayload(Book $book): array
    {
        $payload = $book->load(['author', 'category'])->toArray();

        if ($book->published_date) {
            $payload['published_date'] = $book->published_date->format('Y-m-d');
        }

        if ($book->author && $book->author->birth_date) {
            $payload['author']['birth_date'] = $book->author->birth_date->format('Y-m-d');
        }

        return $payload;
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json($this->normalizeBookPayload($book));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book): JsonResponse
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'isbn' => 'sometimes|required|string|unique:books,isbn,'.$book->id,
            'price' => 'sometimes|required|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'published_date' => 'sometimes|required|date',
        ]);

        $book->update($validated);

        return response()->json($this->normalizeBookPayload($book->load(['author', 'category'])));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Book $book): JsonResponse
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
