@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Supplier Details') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium">{{ $supplier->name }}</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Edit
                        </a>
                        <a href="{{ route('suppliers.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Back to List
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Supplier Information</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <dl>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $supplier->name }}</dd>
                                </div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $supplier->email ?? '-' }}</dd>
                                </div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $supplier->phone ?? '-' }}</dd>
                                </div>
                                {{-- <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contact Person</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $supplier->contact_person ?? '-' }}</dd>
                                </div> --}}
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $supplier->address ?? '-' }}</dd>
                                </div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $supplier->description ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-lg font-medium text-gray-700 dark:text-gray-300">Supplied Books</h4>
                            <a href="{{ route('suppliers.books.create', $supplier) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 text-sm">
                                Add Books
                            </a>
                        </div>

                        @if($supplier->books->count() > 0)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-100 dark:bg-gray-600">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Author</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ISBN</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($supplier->books as $book)
                                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                                    <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                                        {{ $book->title }}
                                                    </a>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $book->author }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $book->isbn }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                            View
                                                        </a>
                                                        <form action="{{ route('suppliers.books.destroy', [$supplier, $book]) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to remove this book from the supplier?')">
                                                                Remove
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                                <p class="text-gray-500 dark:text-gray-400">No books supplied yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
