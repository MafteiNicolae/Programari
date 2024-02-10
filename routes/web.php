<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherControllerController;

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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('appointment')->controller(AppointmentController::class)->group(function(){
        Route::get('indexClient', 'indexClient')->name('appointments.indexClient');
        Route::post('updateClient/{appointment}', 'updateClient')->name('appointments.updateClient');
        Route::get('myAppointments', 'myAppointment')->name('appointments.my');
        Route::post('search', 'search')->name('appointments.search');
    });

    Route::prefix('user')->controller(UserController::class)->group(function(){
        Route::get('myprofile', 'myProfile')->name('user.myProfile');
        Route::post('myprofile/change/{user}', 'change')->name('users.change');
    });
});

Route::middleware('auth', 'is_admin')->group(function () {

    Route::controller(UserController::class)->group(function(){
        Route::get('user/create/{user?}', 'create')->name('users.create');
        Route::get('user/index', 'index')->name('users.index');
        Route::post('user/storeUpdate/{user?}', 'store')->name('users.store');
        Route::post('user/delete/{user}', 'delete')->name('users.delete');
    });
    Route::prefix('appointment')->controller(AppointmentController::class)->group(function(){
        Route::get('create/{appointment?}', 'create')->name('appointments.create');
        Route::get('index', 'index')->name('appointments.index');
        Route::post('store/{appointment?}', 'store')->name('appointments.store');
        Route::post('delete/{appointment}', 'delete')->name('appointments.delete');
    });
    Route::prefix('teacher')->controller(TeacherController::class)->group(function(){
        Route::get('add-edit/{teacher?}', 'addEdit')->name('teachers.add-edit');
        Route::get('index', 'index')->name('teachers.index');
        Route::post('storeUpdate/{teacher?}', 'storeUpdate')->name('teachers.storeUpdate');
        Route::get('delete/{teacher}', 'delete')->name('teachers.delete');
    });

});

require __DIR__.'/auth.php';
