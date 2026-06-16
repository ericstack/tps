<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with(['customer', 'product'])->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        return response()->json(Order::create($this->validated($request)), 201);
    }

    public function show(Order $order)
    {
        return $order->load(['customer', 'product']);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($this->validated($request, $order->id));

        return $order;
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'order_code' => ['required', 'string', 'max:255', 'unique:orders,order_code'.($id ? ",$id" : '')],
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:255'],
            'order_quantity' => ['required', 'integer', 'min:1'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);
    }
}
