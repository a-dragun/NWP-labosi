<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StudentController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
});

Route::middleware(['auth', 'role:nastavnik'])->group(function () {
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/applications', [TaskController::class, 'applications'])->name('tasks.applications');
    Route::post('/tasks/{task}/accept/{student}', [TaskController::class, 'acceptStudent'])->name('tasks.acceptStudent');
    Route::get('/teacher/tasks', [TaskController::class, 'teacherTasks'])->name('teacher.tasks');
});


Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/tasks', [StudentController::class, 'index'])->name('student.tasks');
    Route::post('/tasks/{task}/apply', [StudentController::class, 'apply'])->name('student.apply');
});

require __DIR__.'/auth.php';
