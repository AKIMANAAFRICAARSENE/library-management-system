<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Books Management
    Route::resource('books', BookController::class);

    // Members Management
    Route::resource('members', MemberController::class);

    // Borrows Management
    Route::get('/borrows/delayed', [BorrowController::class, 'delayed'])->name('borrows.delayed');
    Route::post('/borrows/{borrow}/return', [BorrowController::class, 'return'])->name('borrows.return');
    Route::resource('borrows', BorrowController::class);

    // Categories Management
    Route::resource('categories', CategoryController::class);

    // Publishers Management
    Route::resource('publishers', PublisherController::class);

    // Suppliers Management
    Route::resource('suppliers', SupplierController::class);

    // Supplier-Books Relationship
    Route::get('/suppliers/{supplier}/books/create', [SupplierController::class, 'createAddBooks'])->name('suppliers.books.create');
    Route::post('/suppliers/{supplier}/books', [SupplierController::class, 'storeBooks'])->name('suppliers.books.store');
    Route::delete('/suppliers/{supplier}/books/{book}', [SupplierController::class, 'destroyBook'])->name('suppliers.books.destroy');

    // Library Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';
