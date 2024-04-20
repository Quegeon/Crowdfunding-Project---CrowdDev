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
use App\Http\Controllers\pages\admin\management\ManageCompany as M_Company;
use App\Http\Controllers\pages\admin\management\ManageProposal as M_Proposal;

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
            Route::get('/destroy/{id}', 'destroy')->name('management.admin.destroy');
            Route::get('/show/password/{id}', 'show_password')->name('management.admin.show.password');
            Route::get('/visibility/password/{id}', 'visibility_password')->name('management.admin.visibility.password');
            Route::put('/update/password/{id}', 'update_password')->name('management.admin.update.password');
        });
        // M_User
        Route::prefix('user')->controller(M_User::class)->group(function(){
            Route::get('/', 'index')->name('management.user.index');
            Route::post('/store', 'store')->name('management.user.store');
            Route::get('/show/{id}', 'show')->name('management.user.show');
            Route::put('/update/{id}', 'update')->name('management.user.update');
            Route::get('/destroy/{id}', 'destroy')->name('management.user.destroy');
            Route::get('/show/password/{id}', 'show_password')->name('management.user.show.password');
            Route::get('/visibility/password/{id}', 'visibility_password')->name('management.user.visibility.password');
            Route::put('/update/password/{id}', 'update_password')->name('management.user.update.password');
        });
        // M_Company
        Route::prefix('company')->controller(M_Company::class)->group(function(){
            Route::get('/', 'index')->name('management.company.index');
            Route::post('/store', 'store')->name('management.company.store');
            Route::get('/detail/{id}', 'detail')->name('management.company.detail');
            Route::get('/show/{id}', 'show')->name('management.company.show');
            Route::put('/update/{id}', 'update')->name('management.company.update');
            Route::get('/destroy/{id}', 'destroy')->name('management.company.destroy');
            Route::get('/show/password/{id}', 'show_password')->name('management.company.show.password');
            Route::get('/visibility/password/{id}', 'visibility_password')->name('management.company.visibility.password');
            Route::put('/update/password/{id}', 'update_password')->name('management.company.update.password');
        });
        // M_Proposal
        Route::prefix('proposal')->controller(M_Proposal::class)->group(function(){
            Route::get('/', 'index')->name('management.proposal.index');
            Route::post('/store', 'store')->name('management.proposal.store');
            Route::get('/detail/{id}', 'detail')->name('management.proposal.detail');
            Route::get('/show/{id}', 'show')->name('management.proposal.show');
            Route::put('/update/{id}', 'update')->name('management.proposal.update');
            Route::get('/destroy/{id}', 'destroy')->name('management.proposal.destroy');
            Route::get('/download/{id}', 'download')->name('management.proposal.download');
        });
    });

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
