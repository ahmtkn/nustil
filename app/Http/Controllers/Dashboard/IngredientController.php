<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Ingredient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IngredientController extends Controller
{

    public function index()
    {
        $ingredients = Ingredient::all();

        return view('dashboard.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('dashboard.ingredients.editor', ['ingredient' => new Ingredient, 'editing' => false]);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|unique:ingredients',
            'locale' => 'required|in:'.implode(',', array_keys(getLocales())),
            'is_vegan' => 'sometimes',
            'contains_gluten' => 'sometimes',
            'is_nuts' => 'sometimes',
            'is_organic' => 'sometimes',
            'is_saturated_fat' => 'sometimes',
        ]);

        if (!$request->has('locale')) {
            $validated += ['locale' => app()->getLocale()];
        }
        Ingredient::create($validated);

        return redirect()->route('dashboard.ingredients.index');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('dashboard.ingredients.editor', ['ingredient' => $ingredient, 'editing' => true]);
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $reset = ['is_vegan' => 0, 'contains_gluten' => 0, 'is_nuts' => 0, 'is_organic' => 0, 'is_saturated_fat' => 0];
        $request->mergeIfMissing($reset);
        $validated = $this->validate($request, [
            'name' => 'required|unique:ingredients,name,'.$ingredient->id,
            'locale' => 'required|in:'.implode(',', array_keys(getLocales())),
            'is_vegan' => 'sometimes',
            'contains_gluten' => 'sometimes',
            'is_nuts' => 'sometimes',
            'is_organic' => 'sometimes',
            'is_saturated_fat' => 'sometimes',
        ]);

        if (!$request->has('locale')) {
            $validated += ['locale' => app()->getLocale()];
        }
        $ingredient->update($validated);

        return redirect()->route('dashboard.ingredients.index');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->route('dashboard.ingredients.index')->with('message', 'Ingredient deleted successfully');
    }

}
