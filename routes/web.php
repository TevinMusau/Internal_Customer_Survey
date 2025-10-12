<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;


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

