<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Basic statistics
        $totalBooks = Book::sum('quantity');
        $activeMembers = Member::where('status', 'active')->count();
        $inactiveMembers = Member::where('status', 'inactive')->count();
        $teacherMembers = Member::where('role', 'teacher')->count();
        $studentMembers = Member::where('role', 'student')->count();
        $activeLoans = Borrow::where('status', 'borrowed')->count();
        $delayedReturns = Borrow::where('status', 'delayed')->count();

        // Get categories with book counts
        $categories = Category::withCount('books')->get();

        // Get popular books - Fixed GROUP BY issue
        $popularBooks = Book::select('books.id', DB::raw('count(borrows.id) as borrow_count'))
            ->leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
            ->groupBy('books.id')
            ->orderBy('borrow_count', 'desc')
            ->limit(10)
            ->with(['category', 'publisher']) // Eager load relationships
            ->get();

        // Retrieve the complete book data for the popular books
        $bookIds = $popularBooks->pluck('id')->toArray();
        $popularBooks = Book::whereIn('id', $bookIds)
            ->withCount(['borrows as borrow_count'])
            ->with(['category', 'publisher'])
            ->orderByRaw("FIELD(id, " . implode(',', $bookIds) . ")")
            ->get();

        // Recent activity
        $recentActivity = Borrow::select(
                'borrows.created_at',
                'borrows.status',
                'members.name as member_name',
                'books.title as book_title',
                DB::raw("CASE
                    WHEN borrows.status = 'borrowed' THEN 'Borrowed'
                    WHEN borrows.status = 'returned' THEN 'Returned'
                    ELSE 'Delayed'
                END as action")
            )
            ->join('members', 'borrows.member_id', '=', 'members.id')
            ->join('books', 'borrows.book_id', '=', 'books.id')
            ->orderBy('borrows.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('reports.library-report', compact(
            'totalBooks',
            'activeMembers',
            'inactiveMembers',
            'teacherMembers',
            'studentMembers',
            'activeLoans',
            'delayedReturns',
            'categories',
            'popularBooks',
            'recentActivity'
        ));
    }
}
