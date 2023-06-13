<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'cover',
        'title',
        'author',
        'stock',
        'current_stock',
        'publisher',
        'description',
        'pub_year',
        'pages',
        'isbn',
    ];

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
