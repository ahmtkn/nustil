<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Image;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

use App\Http\Requests\FileUploadRequest;
use Illuminate\Foundation\Http\FormRequest;

class MediaController extends Controller
{

    public static function uploadImage(FormRequest $request, string $fieldName, array $options = [])
    {
        $file = $request->file($fieldName);
        $data = $request->validated();
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
            'type' => $options['type'] ?? ($request->has('type') ? $data['type'] : null),
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

    public function store(FileUploadRequest $request)
    {
        $image = self::uploadImage($request, 'image', ['type' => 'gallery-image']);
        return redirect()->route('dashboard.media.index')->with('message', 'Image uploaded successfully');
    }

}

