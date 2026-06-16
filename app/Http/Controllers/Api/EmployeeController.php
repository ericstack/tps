<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::query()->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        return response()->json(Employee::create($this->validated($request)), 201);
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

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'employee_code' => ['required', 'string', 'max:255', 'unique:employees,employee_code'.($id ? ",$id" : '')],
            'employee_name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:50'],
            'birthday' => ['nullable', 'date'],
        ]);
    }
}
