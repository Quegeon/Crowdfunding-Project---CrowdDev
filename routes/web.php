<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;

// Admin
use App\Http\Controllers\pages\admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\pages\admin\management\ManageAdmin as M_Admin;
use App\Http\Controllers\pages\admin\management\ManageUser as M_User;

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

// Admin
Route::get('/', [DashboardAdmin::class, 'index'])->name('dashboard');

    // Management
    Route::prefix('management')->group(function(){
        // M_Admin
        Route::prefix('admin')->controller(M_Admin::class)->group(function(){
            Route::get('/', 'index')->name('management.admin.index');
            Route::post('/store', 'store')->name('management.admin.store');
            Route::get('/show/{id}', 'show')->name('management.admin.show');
            Route::put('/update/{id}', 'update')->name('management.admin.update');
            Route::delete('/destroy', 'destroy')->name('management.admin.destroy');
        });
        // M_User
        Route::prefix('user')->controller(M_User::class)->group(function(){
            Route::get('/', 'index')->name('management.user.index');
            Route::post('/store', 'store')->name('management.user.store');
            Route::put('/update', 'update')->name('management.user.update');
            Route::delete('/destroy', 'destroy')->name('management.user.destroy');
        });
    });

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
