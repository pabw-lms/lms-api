<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public function book(){
        return $this->belongsTo(Book::class);
    }

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
