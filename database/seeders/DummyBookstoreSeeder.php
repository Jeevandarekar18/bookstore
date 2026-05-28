<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyBookstoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Avery Carter', 'email' => 'avery@example.com'],
            ['name' => 'Jordan Rivera', 'email' => 'jordan@example.com'],
            ['name' => 'Taylor Morgan', 'email' => 'taylor@example.com'],
            ['name' => 'Casey Patel', 'email' => 'casey@example.com'],
            ['name' => 'Riley Thompson', 'email' => 'riley@example.com'],
        ];

        foreach ($customers as $customer) {
            User::updateOrCreate(
                ['email' => $customer['email']],
                [
                    'name' => $customer['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_admin' => false,
                ]
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Bookstore Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        $authorNames = [
            'Jane Austen',
            'George Orwell',
            'Haruki Murakami',
            'Margaret Atwood',
            'Neil Gaiman',
            'James Baldwin',
            'Octavia Butler',
            'Toni Morrison',
            'Chimamanda Ngozi Adichie',
            'Sally Rooney',
            'Matt Haig',
            'Frank Herbert',
            'Paulo Coelho',
            'J.R.R. Tolkien',
            'Mary Shelley',
            'Patrick Rothfuss',
            'Yuval Noah Harari',
            'Stephen Hawking',
            'Cormac McCarthy',
            'William Gibson',
        ];

        foreach ($authorNames as $authorName) {
            Author::firstOrCreate(
                ['name' => $authorName],
                [
                    'bio' => fake()->paragraph(),
                    'birth_date' => fake()->dateTimeBetween('-90 years', '-20 years')->format('Y-m-d'),
                ]
            );
        }

        $categories = [
            ['name' => 'Fantasy', 'description' => 'Imaginary worlds and magical adventures.'],
            ['name' => 'Science Fiction', 'description' => 'Future technology, space, and speculative ideas.'],
            ['name' => 'Biography', 'description' => 'Life stories and memoirs.'],
            ['name' => 'History', 'description' => 'Historical narratives and context.'],
            ['name' => 'Literary Fiction', 'description' => 'Modern literary storytelling.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }

        $books = [
            ['title' => 'The Midnight Library', 'author' => 'Matt Haig', 'category' => 'Literary Fiction', 'isbn' => '9780525559474', 'price' => 18.99, 'stock_quantity' => 20, 'description' => 'A thought-provoking story about choices and alternate lives.', 'published_date' => '2020-08-13'],
            ['title' => 'Dune', 'author' => 'Frank Herbert', 'category' => 'Science Fiction', 'isbn' => '9780441172719', 'price' => 22.50, 'stock_quantity' => 18, 'description' => 'Epic sci-fi about politics, power, and desert worlds.', 'published_date' => '1965-08-01'],
            ['title' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'category' => 'Literary Fiction', 'isbn' => '9780141439518', 'price' => 14.25, 'stock_quantity' => 30, 'description' => 'A classic romance of manners and social tension.', 'published_date' => '1813-01-28'],
            ['title' => '1984', 'author' => 'George Orwell', 'category' => 'Science Fiction', 'isbn' => '9780451524935', 'price' => 16.75, 'stock_quantity' => 25, 'description' => 'A chilling dystopian novel about surveillance and truth.', 'published_date' => '1949-06-08'],
            ['title' => 'Kafka on the Shore', 'author' => 'Haruki Murakami', 'category' => 'Fantasy', 'isbn' => '9781400079278', 'price' => 19.95, 'stock_quantity' => 16, 'description' => 'A surreal novel blending reality, dreams, and magical symbolism.', 'published_date' => '2002-09-12'],
            ['title' => 'The Handmaid\'s Tale', 'author' => 'Margaret Atwood', 'category' => 'Science Fiction', 'isbn' => '9780385490818', 'price' => 17.50, 'stock_quantity' => 22, 'description' => 'A powerful dystopian story about autonomy and control.', 'published_date' => '1985-06-14'],
            ['title' => 'American Gods', 'author' => 'Neil Gaiman', 'category' => 'Fantasy', 'isbn' => '9780060558128', 'price' => 21.00, 'stock_quantity' => 17, 'description' => 'A modern fantasy about gods, myths, and hidden realms.', 'published_date' => '2001-06-19'],
            ['title' => 'Giovanni\'s Room', 'author' => 'James Baldwin', 'category' => 'Literary Fiction', 'isbn' => '9780140186736', 'price' => 15.60, 'stock_quantity' => 14, 'description' => 'A poignant novel exploring identity and love.', 'published_date' => '1956-11-01'],
            ['title' => 'Kindred', 'author' => 'Octavia Butler', 'category' => 'Science Fiction', 'isbn' => '9780807083697', 'price' => 18.20, 'stock_quantity' => 19, 'description' => 'A genre-bending novel that combines time travel and history.', 'published_date' => '1979-04-24'],
            ['title' => 'Beloved', 'author' => 'Toni Morrison', 'category' => 'Literary Fiction', 'isbn' => '9781400033416', 'price' => 20.10, 'stock_quantity' => 13, 'description' => 'A powerful story about memory, trauma, and family.', 'published_date' => '1987-09-02'],
            ['title' => 'Half of a Yellow Sun', 'author' => 'Chimamanda Ngozi Adichie', 'category' => 'History', 'isbn' => '9781400044162', 'price' => 18.80, 'stock_quantity' => 15, 'description' => 'A sweeping historical novel about Nigeria during civil war.', 'published_date' => '2006-09-04'],
            ['title' => 'Normal People', 'author' => 'Sally Rooney', 'category' => 'Literary Fiction', 'isbn' => '9781984822185', 'price' => 16.40, 'stock_quantity' => 21, 'description' => 'A contemporary story about relationships and emotional intimacy.', 'published_date' => '2018-08-28'],
            ['title' => 'The Alchemist', 'author' => 'Paulo Coelho', 'category' => 'Biography', 'isbn' => '9780061122415', 'price' => 13.75, 'stock_quantity' => 24, 'description' => 'An inspirational tale of destiny and self-discovery.', 'published_date' => '1988-01-01'],
            ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'category' => 'Fantasy', 'isbn' => '9780547928227', 'price' => 19.25, 'stock_quantity' => 28, 'description' => 'A classic fantasy adventure through Middle-earth.', 'published_date' => '1937-09-21'],
            ['title' => 'Frankenstein', 'author' => 'Mary Shelley', 'category' => 'Science Fiction', 'isbn' => '9780141439471', 'price' => 15.95, 'stock_quantity' => 18, 'description' => 'A gothic science-fiction novel about ambition and consequence.', 'published_date' => '1818-01-01'],
            ['title' => 'The Name of the Wind', 'author' => 'Patrick Rothfuss', 'category' => 'Fantasy', 'isbn' => '9780756404741', 'price' => 24.10, 'stock_quantity' => 12, 'description' => 'An epic fantasy filled with music, magic, and mythology.', 'published_date' => '2007-03-27'],
            ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'category' => 'History', 'isbn' => '9780062316097', 'price' => 26.20, 'stock_quantity' => 10, 'description' => 'A sweeping account of human history and cultural evolution.', 'published_date' => '2011-02-10'],
            ['title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'category' => 'Biography', 'isbn' => '9780553380163', 'price' => 21.80, 'stock_quantity' => 14, 'description' => 'A landmark science book explaining the origins of the universe.', 'published_date' => '1988-04-01'],
            ['title' => 'The Road', 'author' => 'Cormac McCarthy', 'category' => 'Literary Fiction', 'isbn' => '9780307387899', 'price' => 17.90, 'stock_quantity' => 11, 'description' => 'A stark post-apocalyptic novel about survival and hope.', 'published_date' => '2006-09-26'],
            ['title' => 'Neuromancer', 'author' => 'William Gibson', 'category' => 'Science Fiction', 'isbn' => '9780441569595', 'price' => 18.55, 'stock_quantity' => 16, 'description' => 'A cyberpunk classic about digital worlds and the future of technology.', 'published_date' => '1984-07-01'],
        ];

        foreach ($books as $book) {
            $author = Author::where('name', $book['author'])->first();
            $category = Category::where('name', $book['category'])->first();

            if (! $author || ! $category) {
                continue;
            }

            Book::updateOrCreate(
                ['isbn' => $book['isbn']],
                [
                    'title' => $book['title'],
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'price' => $book['price'],
                    'stock_quantity' => $book['stock_quantity'],
                    'description' => $book['description'],
                    'published_date' => $book['published_date'],
                ]
            );
        }
    }
}
