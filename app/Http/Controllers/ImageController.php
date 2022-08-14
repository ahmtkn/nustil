<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\FileUploadRequest;

class ImageController extends Controller
{

    public function __invoke(FileUploadRequest $request)
    {

        $image = \App\Http\Controllers\Dashboard\ProductController::uploadImage($request,'image');
        return response()->json(['success' => true, 'image' => $image]);
    }

}
