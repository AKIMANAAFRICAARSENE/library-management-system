<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::withCount('books')->latest()->paginate(10);
        return view('publishers.index', compact('publishers'));
    }

    public function create()
    {
        return view('publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publishers',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:publishers',
            'description' => 'nullable|string',
        ]);

        Publisher::create($validated);

        return redirect()->route('publishers.index')
            ->with('success', 'Publisher created successfully.');
    }

    public function show(Publisher $publisher)
    {
        $books = $publisher->books()->paginate(10);
        return view('publishers.show', compact('publisher', 'books'));
    }

    public function edit(Publisher $publisher)
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publishers,name,' . $publisher->id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:publishers,email,' . $publisher->id,
            'description' => 'nullable|string',
        ]);

        $publisher->update($validated);

        return redirect()->route('publishers.index')
            ->with('success', 'Publisher updated successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        if ($publisher->books()->count() > 0) {
            return redirect()->route('publishers.index')
                ->with('error', 'Cannot delete publisher with associated books.');
        }

        $publisher->delete();

        return redirect()->route('publishers.index')
            ->with('success', 'Publisher deleted successfully.');
    }
}
