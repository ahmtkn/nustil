<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Recipe;
use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;

class RecipeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $recipes = Recipe::orderByDesc('id')->paginate(20);


        return view('dashboard.recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.recipes.editor', [
            'recipe' => new Recipe(),
            'editing' => false,
            'products' => Product::orderByDesc('id')->get()->groupBy('locale'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRecipeRequest $request)
    {
        $recipe = Recipe::create($request->validated());
        $recipe->products()->attach($request->input('products'));
        $image = MediaController::uploadImage($request, 'image', ['type' => 'recipe-image']);
        $recipe->image()->save($image);
        cache()->flush();

        return redirect()->route('dashboard.recipes.index', $recipe)->with('message', 'Recipe created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Recipe  $recipe
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Recipe $recipe)
    {
        return view('dashboard.recipes.editor', [
            'recipe' => $recipe->load('products', 'image'),
            'editing' => true,
            'products' => Product::all()->groupBy('locale'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        $data = $request->validated();
        $recipe->update($data);
        if ($request->hasFile('image')) {
            $recipe->image()->delete();
            $image = MediaController::uploadImage($request, 'image', ['type' => 'recipe-image']);
            $recipe->image()->save($image);
        }
        $recipe->products()->sync($data['products']);
        cache()->flush();

        return redirect()->route('dashboard.recipes.index', $recipe)->with('message', 'Recipe updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        cache()->flush();

        return redirect()->route('dashboard.recipes.index')->with('message', 'Recipe deleted successfully');
    }

}
