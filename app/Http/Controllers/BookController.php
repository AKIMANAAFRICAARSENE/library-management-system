<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'publisher']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('isbn', 'like', "%{$search}%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('publisher', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Category filter
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Publisher filter
        if ($request->has('publisher_id') && $request->publisher_id) {
            $query->where('publisher_id', $request->publisher_id);
        }

        // Availability filter
        if ($request->has('availability')) {
            if ($request->availability === 'in_stock') {
                $query->where('quantity', '>', 0);
            } elseif ($request->availability === 'out_of_stock') {
                $query->where('quantity', 0);
            }
        }

        $books = $query->latest()->paginate(10);
        $categories = Category::all();
        $publishers = Publisher::all();

        return view('books.index', compact('books', 'categories', 'publishers'));
    }

    public function create()
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $suppliers = Supplier::all();
        return view('books.create', compact('categories', 'publishers', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publisher_id' => 'required|exists:publishers,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'publication_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            // 'price' => 'nullable|numeric|min:0',
        ]);

        // Set default price if not provided
        if (!isset($validated['price'])) {
            $validated['price'] = 0;
        }

        $book = Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $suppliers = Supplier::all();
        return view('books.edit', compact('book', 'categories', 'publishers', 'suppliers'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:13|unique:books,isbn,' . $book->id,
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publisher_id' => 'required|exists:publishers,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'publication_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            // 'price' => 'nullable|numeric|min:0',
        ]);

        // Set default price if not provided
        if (!isset($validated['price'])) {
            $validated['price'] = 0;
        }

        $book->update($validated);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
