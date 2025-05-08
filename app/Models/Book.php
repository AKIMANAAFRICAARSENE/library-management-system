<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'category_id',
        'publisher_id',
        'supplier_id',
        'quantity',
        'description',
        'publication_year',
        // 'price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
