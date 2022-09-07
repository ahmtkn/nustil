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
        $desktop_image = MediaController::uploadImage($request, 'desktop_image', ['type' => 'desktop']);
        $mobile_image = MediaController::uploadImage($request, 'mobile_image', ['type' => 'mobile']);
        $slide->images()->saveMany([$desktop_image, $mobile_image]);
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
        if ($request->hasFile('desktop_image')) {
            $slide->getDesktopImage(false)->delete();
            $desktop_image = MediaController::uploadImage($request, 'desktop_image', ['type' => 'desktop']);
            $slide->images()->save($desktop_image);
        }
        if ($request->hasFile('mobile_image')) {
            $slide->getMobileImage(false)->delete();
            $mobile_image = MediaController::uploadImage($request, 'mobile_image', ['type' => 'mobile']);
            $slide->images()->save($mobile_image);
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
