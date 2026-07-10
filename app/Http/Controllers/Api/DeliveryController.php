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
        $query = Delivery::with(['order', 'employee'])->latest();

        // Field staff only see deliveries assigned to their employee record.
        if ($request->user()->seesOnlyAssignedWork()) {
            $query->where('employee_id', $request->user()->employee_id);
        }

        return $query->paginate($request->integer('per_page', 25));
    }

    public function store(Request $request)
    {
        // Field staff are *assigned* deliveries; they cannot create them.
        if ($request->user()->seesOnlyAssignedWork()) {
            abort(403, 'Deliveries are assigned to you; you cannot create them.');
        }

        $data = $this->validated($request);
        $data['control_number'] = $this->nextControlNumber();

        $delivery = DB::transaction(function () use ($data) {
            $delivery = Delivery::create($data);
            $this->syncOrderStatus($delivery);

            return $delivery;
        });

        return response()->json($delivery, 201);
    }

    public function show(Request $request, Delivery $delivery)
    {
        $this->authorizeAccess($request, $delivery);

        return $delivery->load(['order', 'employee']);
    }

    public function update(Request $request, Delivery $delivery)
    {
        $this->authorizeAccess($request, $delivery);

        DB::transaction(function () use ($request, $delivery) {
            $delivery->update($this->validated($request));
            $this->syncOrderStatus($delivery);
        });

        return $delivery;
    }

    public function destroy(Request $request, Delivery $delivery)
    {
        // Field staff may update their deliveries' status but never delete them.
        if ($request->user()->seesOnlyAssignedWork()) {
            abort(403, 'You cannot delete deliveries.');
        }

        $this->authorizeAccess($request, $delivery);

        $delivery->delete();

        return response()->noContent();
    }

    // Field staff may only touch deliveries assigned to their own employee.
    private function authorizeAccess(Request $request, Delivery $delivery): void
    {
        $user = $request->user();
        if ($user->seesOnlyAssignedWork() && (int) $delivery->employee_id !== (int) $user->employee_id) {
            abort(403, 'This delivery is not assigned to you.');
        }
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
