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

        $image = Dashboard\MediaController::uploadImage($request, 'image');
        return response()->json(['success' => true, 'image' => $image]);
    }

}
