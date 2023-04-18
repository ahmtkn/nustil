<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Image;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Dashboard\ProductStoreRequest;
use App\Http\Requests\Dashboard\ProductUpdateRequest;

class ProductController extends Controller
{

    public function index()
    {
        return view(
            'dashboard.products.index',
            [
                'products' => Product::with('categories')
                    ->orderByDesc('id')
                    ->get(),
            ]
        );
    }

    public function create()
    {
        return view('dashboard.products.editor', ['product' => new Product, 'editing' => false]);
    }

    public function edit(Product $product)
    {
        $product->load('categories', 'nutritions', 'ingredients', 'image');

        return view('dashboard.products.editor', compact('product') + ['editing' => true]);
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();
        $image = MediaController::uploadImage($request, 'image', ['type' => 'product-image']);
        $product = Product::create($data);
        $product->image()->save($image);
        if (isset($data['ingredients'])) {
            $product->ingredients()->attach($data['ingredients']);
        }
        foreach ($data['nutritions'] ?? [] as $nutrition => $amount) {
            $product->nutritions()->attach($nutrition, ['value' => $amount]);
        }
        if (isset($data['categories'])) {
            $product->categories()->attach($data['categories']);
        }
        cache()->flush();

        return redirect()->route('dashboard.products.index')->with('success', 'Product created successfully');
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = ($request->validated());

        if ($request->hasFile('image')) {
            $image = MediaController::uploadImage($request, 'image', ['type' => 'product-image']);
            $product->image()->save($image);
        }
        $product->update($data);

        if (isset($data['ingredients'])) {
            $product->ingredients()->sync($data['ingredients']);
        }
        $product->nutritions()->detach();
        foreach ($data['nutritions'] ?? [] as $nutrition => $value) {
            $product->nutritions()->attach($nutrition, ['value' => $value]);
        }
        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }
        cache()->flush();

        return redirect()->route('dashboard.products.edit', $product)->with('message', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->vipeViews()->delete();
        cache()->flush();

        return redirect()->route('dashboard.products.index')->with('message', 'Product deleted successfully');
    }

}
