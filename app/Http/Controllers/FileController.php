<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    function index()
    {
        return view('javascript_file_upload');
    }

    function upload(Request $request)
    {
        $file_name = time() . '.' . request()->sample_image->getClientOriginalExtension();

        request()->sample_image->move(public_path('images'), $file_name);

        $image_path = asset('images/' . $file_name);

        return response()->json(['image_path' => $image_path]);
    }
}
