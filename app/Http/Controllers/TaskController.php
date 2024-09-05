<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::paginate(5);
        return view('tasks.index', compact('tasks'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:500',
            'deadline' => 'required|date',
        ]);

        Task::create([
            'title' => $request->input('title'),
            'completed' => false,
            'deadline' => $request->input('deadline'),
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);
        $task->update([
            'title' => $request->title,
            'deadline' => $request->deadline,
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->update([
            'completed' => $request->has('completed'),
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
