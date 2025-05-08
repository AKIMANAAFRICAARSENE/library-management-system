<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Book;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('books')->latest()->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:suppliers',
            'description' => 'nullable|string',
        ]);

        $supplier = Supplier::create($validated);

        return redirect()->route('suppliers.show', $supplier)
            ->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        $books = $supplier->books()->paginate(10);
        return view('suppliers.show', compact('supplier', 'books'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
            'description' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.show', $supplier)
            ->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        if ($supplier->books()->count() > 0) {
            return redirect()->route('suppliers.index')
                ->with('error', 'Cannot delete supplier with associated books.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }

    public function createAddBooks(Supplier $supplier)
    {
        $availableBooks = Book::whereDoesntHave('suppliers', function($query) use ($supplier) {
            $query->where('suppliers.id', $supplier->id);
        })->get();

        return view('suppliers.add-books', compact('supplier', 'availableBooks'));
    }

    public function storeBooks(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'books' => 'required|array',
            'books.*' => 'exists:books,id'
        ]);

        $supplier->books()->attach($validated['books']);
        return redirect()->route('suppliers.show', $supplier)
            ->with('success', 'Books added to supplier successfully.');
    }

    public function destroyBook(Supplier $supplier, Book $book)
    {
        $supplier->books()->detach($book->id);
        return redirect()->route('suppliers.show', $supplier)
            ->with('success', 'Book removed from supplier successfully.');
    }
}
