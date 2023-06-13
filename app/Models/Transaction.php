<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'borrowed_at',
        'returned_at',
        'status',
        'user_id',
        'book_id',
    ];

    // protected $casts = [
    //     'user_id' => 'bigint',
    //     'book_id' => 'bigint',
    // ];


    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
