@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Publisher Details') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Publisher Information</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('publishers.edit', $publisher) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Edit
                            </a>
                            <a href="{{ route('publishers.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Basic Information</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                <dl>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $publisher->name }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $publisher->email ?? '-' }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $publisher->phone ?? '-' }}</dd>
                                    </div>
                                    {{-- <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Website</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">
                                            @if($publisher->website)
                                                <a href="{{ $publisher->website }}" target="_blank" class="text-blue-500 hover:underline">{{ $publisher->website }}</a>
                                            @else
                                                -
                                            @endif
                                        </dd>
                                    </div> --}}
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $publisher->address ?? '-' }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $publisher->description ?? '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Published Books</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Author</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ISBN</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @forelse($publisher->books as $book)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->title }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->author }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $book->isbn }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No books published yet.</td>
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
