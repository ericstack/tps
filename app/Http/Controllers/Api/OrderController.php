<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return Order::with(['customer', 'product'])->latest()->paginate($request->integer('per_page', 25));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['order_code'] = $this->nextOrderCode();
        $data['status'] ??= 'placed';

        $order = DB::transaction(function () use ($data) {
            $order = Order::create($data);
            Product::whereKey($data['product_id'])->decrement('quantity', $data['order_quantity']);

            return $order;
        });

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        return $order->load(['customer', 'product']);
    }

    public function update(Request $request, Order $order)
    {
        $data = $this->validated($request, $order);

        DB::transaction(function () use ($order, $data) {
            // Return the stock this order was previously holding...
            Product::whereKey($order->product_id)->increment('quantity', $order->order_quantity);
            // ...then apply the new values and take stock for the new product/quantity.
            $order->update($data);
            Product::whereKey($order->product_id)->decrement('quantity', $order->order_quantity);
        });

        return $order;
    }

    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            Product::whereKey($order->product_id)->increment('quantity', $order->order_quantity);
            $order->delete();
        });

        return response()->noContent();
    }

    // Order code is system-generated (sequential, e.g. ORD-00051), never user-supplied.
    private function nextOrderCode(): string
    {
        return 'ORD-'.str_pad((string) (Order::max('id') + 1), 5, '0', STR_PAD_LEFT);
    }

    private function validated(Request $request, ?Order $order = null): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:255'],
            'order_quantity' => [
                'required', 'integer', 'min:1',
                function ($attribute, $value, $fail) use ($request, $order) {
                    $product = Product::find($request->input('product_id'));
                    if (! $product) {
                        return;
                    }
                    // When editing, this order's existing hold on the same product is available again.
                    $available = $product->quantity;
                    if ($order && (int) $order->product_id === $product->id) {
                        $available += $order->order_quantity;
                    }
                    if ($value > $available) {
                        $fail("Only {$available} unit(s) of {$product->product_name} are in stock.");
                    }
                },
            ],
            'status' => ['nullable', 'in:placed,processing,shipped,completed,cancelled'],
        ]);
    }
}
