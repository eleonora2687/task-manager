<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Mail;



Route::get('/', function () {
    return view('home'); 
})->name('home');


Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create'); // Display the form

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store'); // Handle form submission

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.detail');

Route::get('/analytics', [TaskController::class, 'analytics'])->name('analytics');

Route::get('/tasks/sort', [TaskController::class, 'sort'])->name('tasks.sort');


Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
