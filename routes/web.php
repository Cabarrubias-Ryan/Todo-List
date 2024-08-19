<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

// Welcome route
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
// Prefix for guest routes
Route::prefix('auth')->middleware('guest')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::get('/register', 'registerAccount')->name('register');
        Route::post('/register', 'registerSave')->name('register.save');
        Route::post('/login', 'loginAccount')->name('account.login');
    });
});

// Prefix for authenticated routes
Route::prefix('user')->middleware(['auth', 'user-access:user'])->group(function() {

        Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('user.logout');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('user.dashboard');
        Route::get('/task', 'task')->name('user.task');

        Route::post('/task/store', 'addTask')->name('task.add');
        Route::delete('/task/delete/{id}', 'deleteTask')->name('task.delete');
        Route::put('/task/edit/{id}', 'editTask')->name('task.edit');

    });
});

Route::prefix('admin')->middleware(['auth', 'user-access:admin'])->group(function() {

    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('admin.logout');
    });

    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
        Route::get('/task', 'displayTask')->name('admin.task');
        Route::get('/users', 'displayUser')->name('admin.user');

        Route::get('/users/tasks/{id}', 'getUserTasks')->name('admin.view');
        Route::delete('/task/delete/{id}', 'deleteTask')->name('admin.delete');
        Route::put('/task/edit/{id}', 'editTask')->name('admin.edit');
    });
});
