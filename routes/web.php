<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\NewUserController;
use App\Http\Controllers\EditUserController;



Route::get('/', function () {
    return view('index');
})->name('home');

// -------------------------------- LOGIN ROUTES -------------------------------------------
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

// -------------------------------- LOGOUT ROUTE ----------------------------------------------
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');


// -------------------------------- Dashboard Route -------------------------------------
Route::get('/dashboard/{id}', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/{id}/new-user', [DashboardController::class, 'newUserPage'])->name('new.user');
Route::get('/dashboard/{admin_id}/{user_id}/delete-user', [DashboardController::class, 'deleteUser'])->name('delete.user');

// create new user route
Route::post('/dashboard/{id}/new-user', [NewUserController::class, 'createUser'])->name('createNewUser');

// edit user details
Route::get('/dashboard/{admin_id}/{user_id}/edit-user', [EditUserController::class, 'toEditPage'])->name('edit.user');
Route::post('/dashboard/{admin_id}/{user_id}/edit-user', [EditUserController::class, 'editDetails'])->name('edit.user.post');
