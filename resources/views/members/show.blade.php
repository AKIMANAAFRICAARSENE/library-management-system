@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Member Details') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ $member->name }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('members.edit', $member) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Edit Member
                            </a>
                            <a href="{{ route('members.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-medium mb-3 text-gray-700 dark:text-gray-300">Member Information</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                <dl>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $member->name }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $member->email }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $member->phone ?? '-' }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                            @if($member->role === 'teacher')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100">
                                                    Teacher
                                                </span>
                                            @elseif($member->role === 'staff')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-100">
                                                    Staff
                                                </span>
                                            @elseif($member->role === 'student')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800 dark:bg-teal-700 dark:text-teal-100">
                                                    Student
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100">
                                                    {{ ucfirst($member->role) }}
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Membership Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $member->membership_date->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 border-b border-gray-200 dark:border-gray-600">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                            @if($member->status === 'active')
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
                                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:col-span-2 sm:mt-0">{{ $member->address ?? '-' }}</dd>
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
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Book</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Borrow Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deadline</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Return Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @forelse($borrows as $borrow)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $borrow->book->title }}</td>
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
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        @if($borrow->status === 'borrowed')
                                                            <form action="{{ route('borrows.return', $borrow) }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                                    Return
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a href="{{ route('books.show', $borrow->book) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                            View Book
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No borrow history for this member.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $borrows->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
