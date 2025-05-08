<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrow;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts for cards
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $activeBorrows = Borrow::activeCount();
        $delayedReturns = Borrow::where('status', 'delayed')->count();

        // Recent borrows
        $recentBorrows = Borrow::with(['book', 'member'])
            ->latest()
            ->take(5)
            ->get();

        // Popular categories
        $popularCategories = Category::withCount(['books' => function($query) {
                $query->whereHas('borrows');
            }])
            ->orderBy('books_count', 'desc')
            ->take(5)
            ->get();

        // Books out of stock
        $outOfStockBooks = Book::where('quantity', 0)
            ->latest()
            ->take(5)
            ->get();

        // Most active members
        $activeMembers = Member::withCount(['borrows' => function($query) {
                $query->where('status', 'borrowed')
                    ->orWhere('status', 'delayed');
            }])
            ->orderBy('borrows_count', 'desc')
            ->take(5)
            ->get();

        // Monthly borrow statistics for chart - SQLite compatible
        $currentYear = Carbon::now()->year;
        $monthlyStats = [];

        // Get all borrows from the database
        $borrows = Borrow::all();

        // Group by month manually to avoid SQL compatibility issues
        foreach ($borrows as $borrow) {
            // Only include borrows from the current year
            if ($borrow->created_at && $borrow->created_at->year == $currentYear) {
                $month = $borrow->created_at->month;
                if (!isset($monthlyStats[$month])) {
                    $monthlyStats[$month] = 0;
                }
                $monthlyStats[$month]++;
            }
        }

        // Prepare data for chart
        $months = [];
        $borrowCounts = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->format('M');
            $borrowCounts[] = $monthlyStats[$i] ?? 0;
        }

        return view('dashboard', compact(
            'totalBooks',
            'totalMembers',
            'activeBorrows',
            'delayedReturns',
            'recentBorrows',
            'popularCategories',
            'outOfStockBooks',
            'activeMembers',
            'months',
            'borrowCounts'
        ));
    }
}
