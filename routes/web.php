<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/', function () {
    return redirect(\route('login'));
});

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// 休暇一覧管理
Route::controller(EmployeeController::class)->middleware(['auth'])->name('employee.')->group(function () {
    Route::get('/employee/list/{reload?}', 'list')->name('list');
    Route::get('/employee/create', 'create')->name('create');
    Route::get('/employee/edit/{employee}', 'edit')->name('edit');
    Route::post('/employee', 'store')->name('store');
    Route::put('/employee/{id}', 'update')->name('update');
    Route::delete('/employee/{id}', 'delete')->name('delete');
});

require __DIR__.'/auth.php';
