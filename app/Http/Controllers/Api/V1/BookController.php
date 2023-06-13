<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $books = Book::all();
            $count = count($books);

            for ($x = 0; $x < $count; $x++) {
                $books[$x]->cover = asset('cover/' . $books[$x]->cover);
            }
            // $books->cover = asset('cover/' . $books->cover); // Mengambil URL gambar dari storage

            return response()->json($books);
            // return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cover' => 'required',
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required',
            'current_stock' => 'required',
            'publisher' => 'required',
            'description' => 'required',
            'pub_year' => 'required',
            'pages' => 'required',
            'isbn' => 'nullable'
        ]);

        $cover = $request->file('cover');
        $imageName = time().'.'.$cover->extension();
        $imagePath = public_path(). '/cover';

        $cover->move($imagePath, $imageName);
        // $image = $request->file('cover');
        // $image->storeAs('public/cover', $image->hashName());

         Book::create([
            'cover' => $imageName,
            'title' => $request->title,
            'author' => $request->author,
            'stock' => $request->stock,
            'current_stock' => $request->current_stock,
            'publisher' => $request->publisher,
            'pub_year' => $request->pub_year,
            'pages' => $request->pages,
            'isbn' => $request->isbn,
            'description' => $request->description
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $book->cover = asset('cover/' . $book->cover); // Mengambil URL gambar dari storage

        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Book::destroy($id);
    }

    /**
     * Search book title.
     *
     * @param  string $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $books = Book::where('title', 'like', '%'.$title.'%')->get();
        $count = count($books);

        for ($x = 0; $x < $count; $x++) {
            $books[$x]->cover = asset('cover/' . $books[$x]->cover);
        }

        return response()->json($books);
    }
}
