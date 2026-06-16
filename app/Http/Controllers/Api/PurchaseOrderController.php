<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        return PurchaseOrder::with('items')->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $po = DB::transaction(function () use ($data) {
            $po = PurchaseOrder::create($data);
            $po->items()->createMany($data['items'] ?? []);

            return $po;
        });

        return response()->json($po->load('items'), 201);
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        return $purchaseOrder->load('items');
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $data = $this->validated($request, $purchaseOrder->id);

        DB::transaction(function () use ($purchaseOrder, $data) {
            $purchaseOrder->update($data);

            if (array_key_exists('items', $data)) {
                $purchaseOrder->items()->delete();
                $purchaseOrder->items()->createMany($data['items']);
            }
        });

        return $purchaseOrder->load('items');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return response()->noContent();
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'po_no' => ['required', 'string', 'max:255', 'unique:purchase_orders,po_no'.($id ? ",$id" : '')],
            'supplier' => ['nullable', 'string', 'max:255'],
            'order_date' => ['nullable', 'date'],
            'total' => ['nullable', 'numeric', 'min:0'],
            'payment_status' => ['nullable', 'string', 'max:50'],
            'items' => ['nullable', 'array'],
            'items.*.inventory_id' => ['nullable', 'exists:inventory,id'],
            'items.*.description' => ['nullable', 'string', 'max:255'],
            'items.*.quantity' => ['required_with:items', 'integer', 'min:1'],
        ]);
    }
}
