<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [ToDoController::class, 'index'])->name('todos.index');
Route::post('/todos', [ToDoController::class, 'store'])->name('todos.store');
Route::patch('/todos/{todos_id}', [ToDoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{todos_id}', [ToDoController::class, 'destroy'])->name('todos.destroy');

