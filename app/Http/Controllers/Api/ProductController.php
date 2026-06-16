<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::query()->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        return response()->json(Product::create($this->validated($request)), 201);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request, $product->id));

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code'.($id ? ",$id" : '')],
            'product_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);
    }
}
