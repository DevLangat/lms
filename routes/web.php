<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/admin/company', [App\Http\Controllers\CompanyParametersController::class, 'index'])->name('admin/company');
Route::post('/post_company', [App\Http\Controllers\CompanyParametersController::class, 'store'])->name('post_company');

Route::get('/members/add', [App\Http\Controllers\MemberController::class, 'index'])->name('members/add');
Route::post('/post_member', [App\Http\Controllers\MemberController::class, 'store'])->name('post_member');
Route::get('/members/all', [App\Http\Controllers\MemberController::class, 'show'])->name('members/all');
Route::get('/members_details/{id}', [App\Http\Controllers\MemberController::class, 'membersdetails'])->name('members_details');
Route::get('/member/{id}', [App\Http\Controllers\LoanApplicationController::class, 'show'])->name('member');

Route::get('/loanapplication', [App\Http\Controllers\LoanApplicationController::class, 'index'])->name('loanapplication');
Route::post('/post_loanapplication', [App\Http\Controllers\MemberController::class, 'store'])->name('post_loanapplication');


Route::get('/getDetails/{id}', [App\Http\Controllers\LoanApplicationController::class, 'getDetails'])->name('getDetails');
Route::post('/getUserbyid', [App\Http\Controllers\LoanApplicationController::class, 'getUserbyid']);