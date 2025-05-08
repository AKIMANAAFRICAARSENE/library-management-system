<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BorrowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some books and members
        $books = Book::take(5)->get();
        $members = Member::take(3)->get();

        if ($books->isEmpty() || $members->isEmpty()) {
            $this->command->info('Please seed books and members tables first.');
            return;
        }

        // Create active borrows
        foreach ($books as $index => $book) {
            if ($index < 2) {
                Borrow::create([
                    'book_id' => $book->id,
                    'member_id' => $members->random()->id,
                    'borrow_date' => Carbon::now()->subDays(rand(10, 20)),
                    'deadline' => Carbon::now()->addDays(rand(5, 10)),
                    'status' => 'borrowed',
                ]);
            }
        }

        // Create delayed borrows
        foreach ($books as $index => $book) {
            if ($index >= 2) {
                Borrow::create([
                    'book_id' => $book->id,
                    'member_id' => $members->random()->id,
                    'borrow_date' => Carbon::now()->subDays(rand(20, 30)),
                    'deadline' => Carbon::now()->subDays(rand(1, 10)),
                    'status' => 'borrowed',
                ]);
            }
        }
    }
}
