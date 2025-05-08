@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add Books to Supplier') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium">Add Books to {{ $supplier->name }}</h3>
                    <a href="{{ route('suppliers.show', $supplier) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Back to Supplier
                    </a>
                </div>

                <form action="{{ route('suppliers.books.store', $supplier) }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="books" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Books</label>
                        <select class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 @error('books') border-red-500 @enderror"
                            id="books" name="books[]" multiple required size="10">
                            @foreach($availableBooks as $book)
                                <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->author }})</option>
                            @endforeach
                        </select>
                        @error('books')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Hold Ctrl (or Cmd on Mac) to select multiple books.</p>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Add Selected Books
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
