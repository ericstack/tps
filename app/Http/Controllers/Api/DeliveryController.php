<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    // A delivery's status drives the status of the order it fulfils.
    private const ORDER_STATUS = [
        'pending' => 'processing',
        'in transit' => 'shipped',
        'delivered' => 'completed',
        'failed' => 'cancelled',
    ];

    public function index(Request $request)
    {
        return Delivery::with(['order', 'employee'])->latest()->paginate($request->integer('per_page', 25));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['control_number'] = $this->nextControlNumber();

        $delivery = DB::transaction(function () use ($data) {
            $delivery = Delivery::create($data);
            $this->syncOrderStatus($delivery);

            return $delivery;
        });

        return response()->json($delivery, 201);
    }

    public function show(Delivery $delivery)
    {
        return $delivery->load(['order', 'employee']);
    }

    public function update(Request $request, Delivery $delivery)
    {
        DB::transaction(function () use ($request, $delivery) {
            $delivery->update($this->validated($request));
            $this->syncOrderStatus($delivery);
        });

        return $delivery;
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return response()->noContent();
    }

    // Control number is system-generated (sequential, e.g. DCN-000031), never user-supplied.
    private function nextControlNumber(): string
    {
        return 'DCN-'.str_pad((string) (Delivery::max('id') + 1), 6, '0', STR_PAD_LEFT);
    }

    // Propagate the delivery's status onto its order via the ORDER_STATUS map.
    private function syncOrderStatus(Delivery $delivery): void
    {
        $orderStatus = self::ORDER_STATUS[$delivery->status] ?? null;
        if ($orderStatus) {
            Order::whereKey($delivery->order_id)->update(['status' => $orderStatus]);
        }
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'employee_id' => ['nullable', 'exists:employees,id'],
            'status' => ['nullable', 'in:pending,in transit,delivered,failed'],
        ]);
    }
}
