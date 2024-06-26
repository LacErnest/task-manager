<?php

use App\Http\Controllers\ProjectController;
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
    return redirect('/project/index');
});


Route::prefix('project')->group(function () {
    Route::post('/{projectId}/reorderTasks',[ProjectController::class, 'reorderTasks']);
    Route::post('/store',[ProjectController::class, 'store']);
    Route::get('/index',[ProjectController::class, 'index']);
    Route::get('/create',[ProjectController::class, 'create']);
    Route::get('/show/{id}',[ProjectController::class, 'show'])->name('show-project');
    Route::get('/list-project-tasks',[ProjectController::class, 'listProjectTasks'])->name('listProjectTasks');

    Route::delete('/task/{id}/delete',[TaskController::class, 'destroy']);
    Route::get('{projectId}/task/{id}/edit',[TaskController::class, 'edit']);
    Route::put('{projectId}/task/{id}/update',[TaskController::class, 'update']);
    Route::post('{projectId}/task/store' , [TaskController::class , 'store']);
    Route::get('{project_id}/task/create' , [TaskController::class , 'create']);
});
