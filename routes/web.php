<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'user'], function () {

    Route::group(['middleware' => 'guest'], function () {

        Route::get('login', [LoginController::class, 'index'])->name('user.login');
        Route::get('register', [LoginController::class, 'register'])->name('user.register');
        Route::post('auth', [LoginController::class, 'authentication'])->name('user.authenticate');
        Route::post('check', [LoginController::class, 'checkRegister'])->name('user.check');
    });

    Route::group(['middleware' => 'auth'], function () {


        Route::get('dash', [DashboardController::class, 'index'])->name('user.dash');
        Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');
    });
});




Route::prefix('admin')->group(function () {

    Route::group(['middleware' => 'admin.guest'], function () {

        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('auth', [AdminLoginController::class, 'authentication'])->name('admin.auth');
    });


    Route::group(['middleware' => 'admin.auth'], function () {

        Route::get('dash', [AdminDashboardController::class, 'index'])->name('admin.dash');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});
