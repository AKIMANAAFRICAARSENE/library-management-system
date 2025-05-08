<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'membership_date',
        'role',
        'status'
    ];

    protected $casts = [
        'membership_date' => 'date'
    ];

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
