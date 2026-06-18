<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        return Employee::query()->latest()->paginate($request->integer('per_page', 25));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['employee_code'] = $this->nextEmployeeCode();

        return response()->json(Employee::create($data), 201);
    }

    // Preview the next system-generated employee code (for the create form).
    public function nextCode()
    {
        return ['employee_code' => $this->nextEmployeeCode()];
    }

    public function show(Employee $employee)
    {
        return $employee;
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($this->validated($request, $employee->id));

        return $employee;
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->noContent();
    }

    // Employee code is system-generated (sequential, e.g. EMP-0051) off the highest
    // existing numeric suffix, never user-supplied — so it isn't validated here.
    private function nextEmployeeCode(): string
    {
        $max = Employee::pluck('employee_code')
            ->map(fn ($code) => (int) preg_replace('/\D/', '', (string) $code))
            ->max() ?? 0;

        return 'EMP-'.str_pad((string) ($max + 1), 4, '0', STR_PAD_LEFT);
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'in:Driver,Warehouse Staff,Manager,Clerk,Supervisor,Dispatcher'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:50'],
            'birthday' => ['nullable', 'date'],
        ]);
    }
}
