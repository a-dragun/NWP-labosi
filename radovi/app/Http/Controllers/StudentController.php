<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class StudentController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $tasks = Task::with(['students' => function($query) use ($student) {
            $query->where('users.id', $student->id);
        }])->get();

        return view('student.tasks', compact('tasks', 'student'));
    }

    public function apply(Task $task)
    {
        $student = auth()->user();

        $appliedCount = $student->appliedTasks()->count();
        if ($appliedCount >= 5) {
            return redirect()->back()->with('error', __('You can only apply for 5 tasks.'));
        }

        $priorities = $student->appliedTasks()->get()->pluck('pivot.priority')->filter()->toArray();

        $priority = 1;
        while (in_array($priority, $priorities) && $priority <= 5) {
            $priority++;
        }

        $student->appliedTasks()->attach($task->id, [
            'accepted' => false,
            'priority' => $priority
        ]);

        return redirect()->back()->with('success', __('You have applied for this task'));
    }
}
