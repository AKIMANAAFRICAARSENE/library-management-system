<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'member_id',
        'borrow_date',
        'deadline',
        'return_date',
        'returned_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'deadline' => 'date',
        'return_date' => 'date',
        'returned_at' => 'datetime'
    ];

    /**
     * Get the count of active borrows.
     *
     * @return int
     */
    public static function activeCount()
    {
        return self::where('status', 'borrowed')->count();
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
