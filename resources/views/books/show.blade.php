@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Book Details') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ $book->title }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('books.edit', $book) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Edit Book
                            </a>
                            <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Book Information</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                <dl>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $book->title }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Author</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $book->author }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ISBN</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $book->isbn }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">
                                            @if($book->category)
                                                {{ $book->category->name }}
                                            @else
                                                N/A
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Publisher</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">
                                            @if($book->publisher)
                                                <a href="{{ route('publishers.show', $book->publisher) }}" class="text-blue-500 hover:underline">{{ $book->publisher->name }}</a>
                                            @else
                                                -
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Publication Year</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $book->publication_year }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Quantity Available</dt>
                                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                            <span class="{{ $book->quantity > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ $book->quantity }} {{ $book->quantity == 1 ? 'copy' : 'copies' }}
                                            </span>
                                        </dd>
                                    </div>
                                    {{-- <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">${{ number_format($book->price, 2) }}</dd>
                                    </div> --}}
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $book->description ?? '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Borrow History</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Borrow Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deadline</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Return Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @forelse($book->borrows()->with('member')->latest()->get() as $borrow)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $borrow->member->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $borrow->borrow_date->format('M d, Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $borrow->deadline->format('M d, Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $borrow->return_date ? $borrow->return_date->format('M d, Y') : '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($borrow->status === 'borrowed')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100">
                                                            Borrowed
                                                        </span>
                                                    @elseif($borrow->status === 'returned')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                            Returned
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                                                            Delayed
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No borrow history for this book.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
