<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrdererController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect(\route('login'));
});

// 休暇一覧管理
Route::controller(EmployeeController::class)->middleware(['auth'])->name('employee.')->group(function () {
    Route::get('/employee/list/{reload?}', 'list')->name('list');
    Route::get('/employee/create', 'create')->name('create');
    Route::get('/employee/edit/{employee}', 'edit')->name('edit');
    Route::post('/employee', 'store')->name('store');
    Route::put('/employee/{id}', 'update')->name('update');
    Route::delete('/employee/{id}', 'delete')->name('delete');
});

// 発注元管理
Route::controller(OrdererController::class)->middleware(['auth'])->name('orderer.')->group(function () {
    Route::get('/orderer/list/{reload?}', 'list')->name('list');
    Route::get('/orderer/create', 'create')->name('create');
    Route::get('/orderer/edit/{orderer}', 'edit')->name('edit');
    Route::post('/orderer', 'store')->name('store');
    Route::put('/orderer/{id}', 'update')->name('update');
    Route::delete('/orderer/{id}', 'delete')->name('delete');
});

// 案件管理
Route::controller(ProjectController::class)->middleware(['auth'])->name('project.')->group(function () {
    Route::get('/project/list/{reload?}', 'list')->name('list');
    Route::get('/project/create', 'create')->name('create');
    Route::get('/project/edit/{project}', 'edit')->name('edit');
    Route::post('/project', 'store')->name('store');
    Route::put('/project/{id}', 'update')->name('update');
    Route::delete('/project/{id}', 'delete')->name('delete');
});

// 作業時間管理
Route::controller(TimesController::class)->middleware(['auth'])->name('times.')->group(function () {
    Route::get('/times/list/{reload?}', 'list')->name('list');
    Route::get('/times/create', 'create')->name('create');
    Route::get('/times/edit/{times}', 'edit')->name('edit');
    Route::post('/times', 'store')->name('store');
    Route::put('/times/{id}', 'update')->name('update');
    Route::delete('/times/{id}', 'delete')->name('delete');
});

require __DIR__.'/auth.php';
