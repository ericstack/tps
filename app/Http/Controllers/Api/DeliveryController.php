<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        return Delivery::with(['order', 'employee'])->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        return response()->json(Delivery::create($this->validated($request)), 201);
    }

    public function show(Delivery $delivery)
    {
        return $delivery->load(['order', 'employee']);
    }

    public function update(Request $request, Delivery $delivery)
    {
        $delivery->update($this->validated($request));

        return $delivery;
    }

    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return response()->noContent();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'employee_id' => ['nullable', 'exists:employees,id'],
            'status' => ['nullable', 'integer', 'in:0,1'],
        ]);
    }
}
