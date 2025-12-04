<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TaskController extends Controller
{
    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description' => 'required|string',
            'study_type' => 'required|in:stručni,preddiplomski,diplomski',
        ]);

        Task::create([
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'title_en' => $request->title_en,
            'description' => $request->description,
            'study_type' => $request->study_type,
        ]);

        return redirect()->back()->with('success', __('Task created successfully'));
    }

    public function applications(Task $task)
    {
        if(auth()->id() !== $task->teacher_id) {
            abort(403);
        }
        $students = $task->students;
        return view('tasks.applications', compact('task', 'students'));
    }

public function acceptStudent(Task $task, User $student)
{
    if(auth()->id() !== $task->teacher_id) {
        abort(403);
    }
    $pivot = $task->students()->where('users.id', $student->id)->first()->pivot;
    if($pivot->priority != 1) {
        return redirect()->back()->with('error', 'You can only accept a student with priority 1.');
    }
    $task->students()->updateExistingPivot($task->students->pluck('id')->toArray(), ['accepted' => false]);
    $task->students()->updateExistingPivot($student->id, ['accepted' => true]);
    return redirect()->back()->with('success', 'Student accepted!');
}



    public function teacherTasks()
    {
        $teacher = auth()->user();
        $tasks = Task::where('teacher_id', $teacher->id)->get();
        return view('tasks.teacher_tasks', compact('tasks'));
    }
}
