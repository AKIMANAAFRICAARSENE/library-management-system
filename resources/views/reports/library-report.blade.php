@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Library Management System Report') }}
        </h2>
        <button
            onclick="window.print()"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 print:hidden"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Report
        </button>
    </div>
@endsection

@push('styles')
<style>
    @media print {
        /* Hide non-essential elements when printing */
        nav, footer, .hidden-print, button {
            display: none !important;
        }

        /* Make the content full width when printing */
        .py-12, .max-w-7xl, .sm\:px-6, .lg\:px-8 {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
        }

        /* Ensure dark mode doesn't affect printing */
        .dark\:bg-gray-800, .dark\:bg-gray-700, .dark\:text-gray-200, .dark\:text-gray-100, .dark\:text-gray-400 {
            background-color: white !important;
            color: black !important;
        }

        /* Ensure good page breaks */
        .bg-white {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }

        body {
            font-size: 12pt;
        }

        h2, h3 {
            margin-top: 20px;
        }

        /* Add page title */
        @page {
            size: letter portrait;
            margin: 1cm;
        }

        /* For activity-only printing */
        body.print-activity-only .bg-white:not(.activity-section),
        body.print-activity-only .print:hidden,
        body.print-activity-only nav,
        body.print-activity-only .date-filter-form,
        body.print-activity-only .grid {
            display: none !important;
        }

        body.print-activity-only .activity-section {
            display: block !important;
            page-break-before: avoid;
            margin-top: 0;
            padding-top: 0;
        }

        body.print-activity-only {
            display: block !important;
        }
    }
</style>
@endpush

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Date Filter Form -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 print:hidden date-filter-form">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Filter Report by Date Range</h3>

                <form action="{{ route('reports.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate ? $startDate->format('Y-m-d') : '' }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate ? $endDate->format('Y-m-d') : '' }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Apply Filter
                            </button>
                            @if($startDate || $endDate)
                                <a href="{{ route('reports.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Current Filter Indicator -->
        @if($startDate && $endDate)
        <div class="bg-blue-50 dark:bg-blue-900 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        Showing results from <strong>{{ $startDate->format('M d, Y') }}</strong> to <strong>{{ $endDate->format('M d, Y') }}</strong>
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- System Overview -->
        {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">System Overview</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-700 dark:text-blue-300">Total Books</h4>
                        <p class="text-3xl font-bold text-blue-800 dark:text-blue-200">{{ $totalBooks }}</p>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4">
                        <h4 class="font-semibold text-green-700 dark:text-green-300">Active Members</h4>
                        <p class="text-3xl font-bold text-green-800 dark:text-green-200">{{ $activeMembers }}</p>
                    </div>

                    <div class="bg-amber-50 dark:bg-amber-900 rounded-lg p-4">
                        <h4 class="font-semibold text-amber-700 dark:text-amber-300">Current Borrows</h4>
                        <p class="text-3xl font-bold text-amber-800 dark:text-amber-200">{{ $activeLoans }}</p>
                    </div>

                    <div class="bg-red-50 dark:bg-red-900 rounded-lg p-4">
                        <h4 class="font-semibold text-red-700 dark:text-red-300">Delayed Returns</h4>
                        <p class="text-3xl font-bold text-red-800 dark:text-red-200">{{ $delayedReturns }}</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 activity-section">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Borrowing Activities</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Book</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($recentActivity as $activity)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->member_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->book_title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $activity->action }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($activity->status === 'borrowed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                Borrowed
                                            </span>
                                        @elseif($activity->status === 'returned')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                Returned
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                Delayed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No recent activity found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Book Categories -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Book Categories</h3>

                    <div class="space-y-4">
                        @foreach($categories as $category)
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $totalBooks > 0 ? ($category->books_count / $totalBooks) * 100 : 0 }}%"></div>
                                </div>
                                <span class="flex-shrink-0 ml-2 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $category->name }} ({{ $category->books_count }})
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Member Statistics -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Member Statistics</h3>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Active</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $activeMembers }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Inactive</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $inactiveMembers }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Teachers</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $teacherMembers }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Students</h4>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $studentMembers }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Popular Books -->
        {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Most Popular Books</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Author</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Times Borrowed</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Available Copies</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse($popularBooks as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $book->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $book->author }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $book->category ? $book->category->name : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $book->borrow_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $book->quantity }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No popular books found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printActivityOnly() {
        // Add the print class to body
        document.body.classList.add('print-activity-only');

        // Add a title for the activity-only print
        let title = document.createElement('h2');
        title.className = 'activity-print-title font-semibold text-xl text-center mb-4';
        title.innerText = 'Library Activity Report';

        // Add date range if filtered
        @if($startDate && $endDate)
        let dateRange = document.createElement('p');
        dateRange.className = 'text-center mb-4';
        dateRange.innerText = 'Period: {{ $startDate->format("M d, Y") }} to {{ $endDate->format("M d, Y") }}';
        document.querySelector('.activity-section .p-6').prepend(dateRange);
        @endif

        document.querySelector('.activity-section .p-6').prepend(title);

        // Delay printing slightly to ensure DOM updates
        setTimeout(function() {
            window.print();

            // Remove the temporary elements and class after printing
            setTimeout(function() {
                document.body.classList.remove('print-activity-only');
                const titleElem = document.querySelector('.activity-print-title');
                if (titleElem) titleElem.remove();

                @if($startDate && $endDate)
                const dateRangeElem = document.querySelector('.activity-section .p-6 p.text-center');
                if (dateRangeElem) dateRangeElem.remove();
                @endif
            }, 500);
        }, 100);
    }
</script>
@endpush
