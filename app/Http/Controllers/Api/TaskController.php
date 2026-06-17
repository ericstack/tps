<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::with('employee')->latest()->paginate(25);
    }

    public function store(Request $request)
    {
        return response()->json(Task::create($this->validated($request)), 201);
    }

    public function show(Task $task)
    {
        return $task->load('employee');
    }

    public function update(Request $request, Task $task)
    {
        $task->update($this->validated($request));

        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'assigned_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'employee_id' => ['nullable', 'exists:employees,id'],
            'status' => ['nullable', 'in:open,in progress,done'],
        ]);
    }
}
