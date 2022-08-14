<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function __invoke(Image $image)
    {
        return response()->file(storage_path('app/'.$image->path));
    }

}
