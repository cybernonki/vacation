<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdererController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesController;
use App\Http\Controllers\DaysController;
use App\Http\Controllers\MonthController;
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

// ユーザー一覧
Route::controller(UserController::class)->middleware(['auth'])->name('user.')->group(function () {
    Route::get('/user/list/{reload?}', 'list')->name('list');
    Route::delete('/user/{id}', 'delete')->name('delete');
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

// 日別作業時間管理
Route::controller(DaysController::class)->middleware(['auth'])->name('days.')->group(function () {
    Route::get('/days/list/{reload?}', 'list')->name('list');
    Route::get('/days/detail/{employee_id}/{date}', 'detail')->name('detail');
});

// 月別作業時間管理
Route::controller(MonthController::class)->middleware(['auth'])->name('month.')->group(function () {
    Route::get('/month/list/{reload?}', 'list')->name('list');
    Route::get('/month/detail/{employee_id}/{month}', 'detail')->name('detail');
    Route::get('/month/days/{employee_id}/{date}', 'days')->name('days');
});

require __DIR__.'/auth.php';
