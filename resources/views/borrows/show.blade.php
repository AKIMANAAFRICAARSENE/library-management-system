@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Borrow Details') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Borrow ID: #{{ $borrow->id }}</h3>
                        <div class="flex space-x-2">
                            @if($borrow->status === 'borrowed')
                                <form action="{{ route('borrows.return', $borrow) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        Return Book
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('borrows.edit', $borrow) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Edit
                            </a>
                            <a href="{{ route('borrows.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
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
                            <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Book Information</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                <dl>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">
                                            <a href="{{ route('books.show', $borrow->book) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                                {{ $borrow->book->title }}
                                            </a>
                                        </dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Author</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->book->author }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ISBN</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->book->isbn }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">
                                            @if($borrow->book->category)
                                                {{ $borrow->book->category->name }}
                                            @else
                                                N/A
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Member Information</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                <dl>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">
                                            <a href="{{ route('members.show', $borrow->member) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                                                {{ $borrow->member->name }}
                                            </a>
                                        </dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->member->email }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->member->phone ?? '-' }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                            @if($borrow->member->status === 'active')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">
                                                    Inactive
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Borrow Information</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                            <dl>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Borrow Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->borrow_date->format('M d, Y') }}</dd>
                                </div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deadline</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->deadline->format('M d, Y') }}</dd>
                                </div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Return Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->return_date ? $borrow->return_date->format('M d, Y') : '-' }}</dd>
                                </div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
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
                                    </dd>
                                </div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $borrow->notes ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
