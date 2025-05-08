<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a category
        $category = Category::firstOrCreate(
            ['name' => 'Fiction'],
            ['description' => 'Fiction books including novels, short stories, etc.']
        );

        // Get or create a publisher
        $publisher = Publisher::firstOrCreate(
            ['name' => 'Sample Publisher'],
            [
                'address' => '123 Publisher St, New York, NY',
                'phone' => '555-123-4567',
                'email' => 'contact@samplepublisher.com',
            ]
        );

        // Create sample books
        $books = [
            [
                'title' => 'The Great Novel',
                'author' => 'John Author',
                'isbn' => '9781234567897',
                'publication_year' => 2020,
                'quantity' => 5,
                'category_id' => $category->id,
                'publisher_id' => $publisher->id,
                'price' => 19.99,
            ],
            [
                'title' => 'Mystery of the Library',
                'author' => 'Jane Writer',
                'isbn' => '9781234567898',
                'publication_year' => 2021,
                'quantity' => 3,
                'category_id' => $category->id,
                'publisher_id' => $publisher->id,
                'price' => 24.99,
            ],
            [
                'title' => 'Programming 101',
                'author' => 'Dev Coder',
                'isbn' => '9781234567899',
                'publication_year' => 2022,
                'quantity' => 8,
                'category_id' => $category->id,
                'publisher_id' => $publisher->id,
                'price' => 29.99,
            ],
            [
                'title' => 'History of Libraries',
                'author' => 'Historian Writer',
                'isbn' => '9781234567890',
                'publication_year' => 2019,
                'quantity' => 2,
                'category_id' => $category->id,
                'publisher_id' => $publisher->id,
                'price' => 34.99,
            ],
            [
                'title' => 'Future of Books',
                'author' => 'Forward Thinker',
                'isbn' => '9781234567801',
                'publication_year' => 2023,
                'quantity' => 7,
                'category_id' => $category->id,
                'publisher_id' => $publisher->id,
                'price' => 39.99,
            ],
        ];

        foreach ($books as $bookData) {
            Book::firstOrCreate(
                ['isbn' => $bookData['isbn']],
                $bookData
            );
        }
    }
}
