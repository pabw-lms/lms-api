<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Transaction::all();
    }

    public function show($id)
    {
        return Transaction::find($id)
        ->join('users', 'user_id', '=', 'users.id')
        ->join('books', 'book_id', '=', 'books.id')
        ->select('users.email', 'books.title')
        ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrowed_at' => 'required',
            'returned_at' => 'nullable',
            'status' => 'required',
            'user_id' => 'required',
            'book_id' => 'required',
        ]);

        Transaction::create([
            'borrowed_at' => $request->borrowed_at,
            'returned_at' => $request->returned_at,
            'status' => $request->status,
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
        ]);

        return response(['message' => 'Transaction success'], 200);
    }
}
