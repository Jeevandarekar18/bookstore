<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns books ordered by newest first when sort is requested', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $author = Author::factory()->create();
    $category = Category::factory()->create();

    Book::factory()->createMany([
        ['title' => 'First', 'author_id' => $author->id, 'category_id' => $category->id],
        ['title' => 'Second', 'author_id' => $author->id, 'category_id' => $category->id],
        ['title' => 'Third', 'author_id' => $author->id, 'category_id' => $category->id],
    ]);

    $response = $this->actingAs($admin, 'sanctum')
        ->getJson('/api/books?per_page=2&sort=-id');

    $response->assertOk();
    $response->assertJsonPath('per_page', 2);
    expect($response->json('data'))->toHaveCount(2);
    expect(collect($response->json('data'))->pluck('id')->all())->toBe([3, 2]);
});

it('paginates authors and sorts them newest first', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    Author::factory()->count(5)->create();

    $response = $this->actingAs($admin, 'sanctum')
        ->getJson('/api/authors?per_page=2');

    $response->assertOk();
    $response->assertJsonPath('per_page', 2);
    $response->assertJsonPath('current_page', 1);
    $response->assertJsonPath('last_page', 3);
    expect($response->json('data'))->toHaveCount(2);
    expect(collect($response->json('data'))->pluck('id')->all())->toBe([5, 4]);
});

it('returns edit-friendly dates for books and authors', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $author = Author::factory()->create([
        'birth_date' => '1990-06-15',
    ]);
    $category = Category::factory()->create();
    $book = Book::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'published_date' => '2024-01-20',
    ]);

    $bookResponse = $this->actingAs($admin, 'sanctum')
        ->getJson('/api/books/'.$book->id);

    $bookResponse->assertOk();
    $bookResponse->assertJsonPath('published_date', '2024-01-20');
    $bookResponse->assertJsonPath('author.birth_date', '1990-06-15');

    $authorResponse = $this->actingAs($admin, 'sanctum')
        ->getJson('/api/authors/'.$author->id);

    $authorResponse->assertOk();
    $authorResponse->assertJsonPath('birth_date', '1990-06-15');
});

it('normalizes deny status to cancelled for admin order updates', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $order = Order::factory()->create([
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin, 'sanctum')
        ->patchJson('/api/orders/'.$order->id, [
            'status' => 'deny',
        ]);

    $response->assertOk();
    $response->assertJsonPath('status', 'cancelled');
    $this->assertSame('cancelled', $order->fresh()->status);
});
