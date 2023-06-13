<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request) {
        $file = $request->file('file');
        $imageName = time().'.'.$file->extension();
        $imagePath = public_path(). '/upload';

        $file->move($imagePath, $imageName);
    }
}
