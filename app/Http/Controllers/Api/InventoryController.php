<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return Inventory::with(['product', 'category'])->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        return response()->json(Inventory::create($this->validated($request)), 201);
    }

    public function show(Inventory $inventory)
    {
        return $inventory->load(['product', 'category']);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $inventory->update($this->validated($request, $inventory->id));

        return $inventory;
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'serial_no' => ['required', 'string', 'max:255', 'unique:inventory,serial_no'.($id ? ",$id" : '')],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'product_id' => ['required', 'exists:products,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);
    }
}
