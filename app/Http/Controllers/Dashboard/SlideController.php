<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Slide;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DeleteSlideRequest;
use App\Http\Requests\Dashboard\CreateSlideRequest;
use App\Http\Requests\Dashboard\UpdateSlideRequest;

class SlideController extends Controller
{

    public function index()
    {
        $slides = Slide::all();

        return view('dashboard.slides.index', compact('slides'));
    }


    public function create()
    {
        return view('dashboard.slides.editor', ['slide' => new Slide()]);
    }

    public function store(CreateSlideRequest $request)
    {
        $slide = Slide::create($request->validated());
        $image = ProductController::uploadImage($request, 'image', ['type' => 'srcset 1024w']);
        $slide->images()->save($image);
        cache()->flush();

        return redirect()->route('dashboard.slides.index')->with('message', 'Slide created successfully');
    }

    public function edit(Slide $slide)
    {
        return view('dashboard.slides.editor', compact('slide'));
    }

    public function update(UpdateSlideRequest $request, Slide $slide)
    {
        $slide->update($request->validated());
        if ($request->hasFile('image')) {
            $image = ProductController::uploadImage($request, 'image', ['type' => 'srcset 1024w']);
            $slide->images()->save($image);
        }
        cache()->flush();

        return redirect()->route('dashboard.slides.index')->with('message', 'Slide updated successfully');
    }

    public function destroy(DeleteSlideRequest $request, Slide $slide)
    {
        $slide->image()->delete();
        $slide->delete();
        cache()->flush();

        return redirect()->route('dashboard.slides.index')->with('message', 'Slide deleted successfully');
    }

}
