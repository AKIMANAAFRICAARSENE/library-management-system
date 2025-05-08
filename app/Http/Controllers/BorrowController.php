<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = Borrow::with(['book', 'member'])->latest()->paginate(10);
        return view('borrows.index', compact('borrows'));
    }

    public function create()
    {
        $books = Book::where('quantity', '>', 0)->get();
        $members = Member::where('status', 'active')->get();
        return view('borrows.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'deadline' => 'required|date|after:borrow_date',
            'status' => 'required|in:borrowed,returned,delayed',
            'notes' => 'nullable|string',
        ]);

        $book = Book::findOrFail($validated['book_id']);

        if ($book->quantity <= 0) {
            return redirect()->back()
                ->with('error', 'Book is not available for borrowing.');
        }

        $borrow = Borrow::create($validated);

        // Update book quantity
        $book->decrement('quantity');

        return redirect()->route('borrows.show', $borrow)
            ->with('success', 'Book borrowed successfully.');
    }

    public function show(Borrow $borrow)
    {
        return view('borrows.show', compact('borrow'));
    }

    public function edit(Borrow $borrow)
    {
        $books = Book::all();
        $members = Member::all();
        return view('borrows.edit', compact('borrow', 'books', 'members'));
    }

    public function update(Request $request, Borrow $borrow)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'borrow_date' => 'required|date',
            'deadline' => 'required|date|after:borrow_date',
            'status' => 'required|in:borrowed,returned,delayed',
            'notes' => 'nullable|string',
        ]);

        // If book is being returned, increment the quantity
        if ($borrow->status === 'borrowed' && $validated['status'] === 'returned') {
            $book = Book::findOrFail($validated['book_id']);
            $book->increment('quantity');
        }

        $borrow->update($validated);

        return redirect()->route('borrows.show', $borrow)
            ->with('success', 'Borrow record updated successfully.');
    }

    public function destroy(Borrow $borrow)
    {
        if ($borrow->status === 'borrowed') {
            $book = Book::findOrFail($borrow->book_id);
            $book->increment('quantity');
        }

        $borrow->delete();

        return redirect()->route('borrows.index')
            ->with('success', 'Borrow record deleted successfully.');
    }

    public function delayed()
    {
        // First, update any borrows that are past their deadline but still marked as 'borrowed'
        Borrow::where('status', 'borrowed')
            ->where('deadline', '<', Carbon::now())
            ->update(['status' => 'delayed']);

        // Then get all delayed borrows
        $delayedBorrows = Borrow::with(['book', 'member'])
            ->where('status', 'delayed')
            ->latest()
            ->paginate(10);

        return view('borrows.delayed', compact('delayedBorrows'));
    }

    public function return(Borrow $borrow)
    {
        // Only update if the book is currently borrowed or delayed
        if ($borrow->status === 'borrowed' || $borrow->status === 'delayed') {
            // Update the borrow status
            $borrow->update([
                'status' => 'returned',
                'return_date' => Carbon::now(),
                'returned_at' => Carbon::now()
            ]);

            // Increment the book quantity
            $book = Book::findOrFail($borrow->book_id);
            $book->increment('quantity');

            return redirect()->back()
                ->with('success', 'Book returned successfully.');
        }

        return redirect()->back()
            ->with('error', 'This book has already been returned.');
    }
}
