<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Image;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Http\FormRequest;

class MediaController extends Controller
{

    public static function uploadImage(FormRequest $request, string $fieldName, array $options = [])
    {
        $file = $request->file($fieldName);
        $dir = $options['dir'] ?? 'uploads';
        $options = drupal_array_merge_deep($options, [
            'extra' => [
                'visiblity' => $options['extra']['visibility'] ?? 'public',
            ],
        ]);
        $name = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->storeAs($dir, $name, $options['extra']);
        $image = Image::create([
            'name' => $options['name'] ?? $name,
            'path' => $dir.DIRECTORY_SEPARATOR.$name,
            'type' => $options['type'] ?? ($request->has('type') ? $request->validated('type') : null),
            'mime_type' => $file->getMimeType(),
        ]);
        cache()->flush();

        return $image;
    }

    public function album()
    {
        return view('dashboard.media.album', [
            'images' => Image::with('imageable')->orderBy('created_at', 'desc')->paginate(15),
        ]);
    }

}

