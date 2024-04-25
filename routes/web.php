<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;

// Login
use App\Http\Controllers\pages\LoginController as Login;

// Admin
use App\Http\Controllers\pages\admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\pages\admin\management\ManageAdmin as M_Admin;
use App\Http\Controllers\pages\admin\management\ManageUser as M_User;
use App\Http\Controllers\pages\admin\management\ManageCompany as M_Company;
use App\Http\Controllers\pages\admin\management\ManageProposal as M_Proposal;
use App\Http\Controllers\pages\admin\management\ManageFunding as M_Funding;

//User
use App\Http\Controllers\pages\user\DashboardController as DashboardUser;
use App\Http\Controllers\pages\user\ProposalController as U_Proposal;
use App\Http\Controllers\pages\user\CompanyController as U_Company;

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

// Login & Register
Route::get('/', [Login::class, 'index'])->name('login');
Route::post('/postlogin', [Login::class, 'postlogin'])->name('login.post');
Route::get('/logout', [Login::class, 'logout'])->name('logout');
Route::get('/register', [Login::class, 'register'])->name('register');
Route::post('/postregister', [Login::class, 'postregister'])->name('register.post');
Route::get('/register-company', [Login::class, 'register_company'])->name('register.company');
Route::post('/postregister-company', [Login::class, 'postregister_company'])->name('register.company.post');

// Admin
Route::get('/dashboard-admin', [DashboardAdmin::class, 'index'])->name('dashboard.admin');

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
            Route::get('/show/selection/{id}', 'show_selection')->name('management.proposal.show.selection');
            Route::put('/update/{id}', 'update')->name('management.proposal.update');
            Route::put('/selection/{id}', 'company_select')->name('management.proposal.selection');
            Route::get('/destroy/{id}', 'destroy')->name('management.proposal.destroy');
            Route::get('/done/{id}', 'done')->name('management.proposal.done');
            Route::get('/download/{id}', 'download')->name('management.proposal.download');
        });
        // M_Funding
        Route::prefix('funding')->controller(M_Funding::class)->group(function(){
            Route::get('/', 'index')->name('management.funding.index');
            Route::post('/store', 'store')->name('management.funding.store');
            Route::get('/show/{id}', 'show')->name('management.funding.show');
            Route::put('/update/{id}', 'update')->name('management.funding.update');
            Route::get('/destroy/{id}', 'destroy')->name('management.funding.destroy');
            Route::get('/download/{id}', 'download')->name('management.funding.download');
        });
    });

// User
Route::get('/dashboard-user', [DashboardUser::class, 'index'])->name('dashboard.user');

    Route::prefix('user')->group(function(){
        // Proposal
        Route::prefix('proposal')->controller(U_Proposal::class)->group(function(){
            Route::get('/view-proposal', 'view_proposal')->name('user.proposal.view-proposal');
            Route::get('/view-proposal/show/fund/{id}/{is_view_proposal}', 'show_fund')->name('user.proposal.view-proposal.show.fund');
            Route::post('/view-proposal/fund/{id}', 'fund')->name('user.proposal.view-proposal.fund');
            Route::get('/view-proposal/detail-funding/{id}', 'detail_funding_vp')->name('user.proposal.view-proposal.detail-funding');
            Route::get('/view-proposal/download/{id}', 'download')->name('user.proposal.view-proposal.download');
            // Route::get('/view-proposal/vote/detail/{id}', 'detail-vote')->name('user.proposal.view-proposal.vote.detail');
            // Route::get('/view-proposal/vote/approve/{id}', 'approve')->name('user.proposal.view-proposal.vote.approve');
            // Route::get('/view-proposal/vote/reject/{id}', 'reject')->name('user.proposal.view-proposal.vote.reject');
            
            Route::get('/my-proposal', 'my_proposal')->name('user.proposal.my-proposal');
            Route::post('/my-proposal/store', 'store_proposal')->name('user.proposal.my-proposal.store');
            Route::get('/my-proposal/show/edit/{id}', 'show_edit')->name('user.proposal.my-proposal.show.edit');
            Route::put('/my-proposal/update/proposal/{id}', 'update_proposal')->name('user.proposal.my-proposal.update');
            Route::get('/my-proposal/destroy/{id}', 'destroy_proposal')->name('user.proposal.my-proposal.destroy');
            Route::get('/my-proposal/show/fund/{id}/{is_view_proposal}', 'show_fund')->name('user.proposal.my-proposal.show.fund');
            Route::post('/my-proposal/fund/{id}', 'fund')->name('user.proposal.my-proposal.fund');
            Route::get('/my-proposal/detail/{id}', 'detail_mp')->name('user.proposal.my-proposal.detail');
            Route::get('/my-proposal/show/selection/{id}', 'show_selection')->name('user.proposal.my-proposal.show.selection');
            Route::post('/my-proposal/company-select/{id}', 'company_select')->name('user.proposal.my-proposal.company-select');
        });

        // Company
        Route::prefix('company')->controller(U_Company::class)->group(function(){
            Route::get('/view-company', 'view_company')->name('user.company.view-company');
            Route::get('/selection', 'company_selection')->name('user.company.selection');
        });
    });


// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
