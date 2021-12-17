<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route("tasks.index");
});

Route::resource('tasks', TaskController::class)->parameters(['tasks' => 'id'])->except(['edit']);

Route::post('/tasks/{id}/restore', [TaskController::class, 'restore'])->name("tasks.restore");

Route::delete('/tasks/all/delete', [TaskController::class, 'deleteDoneTasks'])->name("tasks.deleteDones");
