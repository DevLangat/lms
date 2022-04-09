<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware('auth');
//Company Parameters
Route::get('/admin/company', [App\Http\Controllers\CompanyParametersController::class, 'index'])->name('admin/company')->middleware('auth');
Route::post('/post_company', [App\Http\Controllers\CompanyParametersController::class, 'store'])->name('post_company');
//Members Routes
Route::get('/members/add', [App\Http\Controllers\MemberController::class, 'index'])->name('members/add')->middleware('auth');
Route::post('/post_member', [App\Http\Controllers\MemberController::class, 'store'])->name('post_member')->middleware('auth');
Route::get('/members/all', [App\Http\Controllers\MemberController::class, 'show'])->name('members/all')->middleware('auth');
Route::get('/members_details/{id}', [App\Http\Controllers\MemberController::class, 'membersdetails'])->name('members_details');
//Loan Routes
Route::get('/loanapplication', [App\Http\Controllers\LoanApplicationController::class, 'index'])->name('loanapplication')->middleware('auth');
Route::post('/post_loanapplication', [App\Http\Controllers\LoanApplicationController::class, 'store'])->name('post_loanapplication')->middleware('auth');
Route::get('/getDetails/{id}', [App\Http\Controllers\LoanApplicationController::class, 'getDetails'])->name('getDetails');
Route::post('/getUserbyid', [App\Http\Controllers\LoanApplicationController::class, 'getUserbyid']);
Route::post('/getLoantypes', [App\Http\Controllers\LoanApplicationController::class, 'getLoantypes']);
Route::get('/loans/all', [App\Http\Controllers\LoanApplicationController::class, 'show'])->name('loans/all')->middleware('auth');
Route::get('/loansApproved/all', [App\Http\Controllers\LoanApplicationController::class, 'showApproved'])->name('loansApproved/all')->middleware('auth');
Route::get('/loansrejected/all', [App\Http\Controllers\LoanApplicationController::class, 'showRejectedloans'])->name('loansrejected/all')->middleware('auth');
Route::get('/loaninterests/all', [App\Http\Controllers\LoanInterestController::class, 'show'])->name('loaninterests/all')->middleware('auth');

Route::post('/loan/reject', [App\Http\Controllers\LoanApplicationController ::class, 'destroy'])->name('loan/reject')->middleware('auth');

Route::post('/loan/approve', [App\Http\Controllers\LoanApplicationController ::class, 'approve'])->name('loan/approve')->middleware('auth');
Route::get('/loan_details/{id}', [App\Http\Controllers\LoanApplicationController::class, 'loan_details'])->name('loan_details')->middleware('auth');
Route::get('/repayment', [App\Http\Controllers\RepaymentsController::class, 'index'])->name('/repayment')->middleware('auth');
Route::get('/repayments/all', [App\Http\Controllers\RepaymentsController::class, 'show'])->name('repayments/all')->middleware('auth');
Route::post('/post_repayments', [App\Http\Controllers\RepaymentsController ::class, 'store'])->name('post_repayments')->middleware('auth');//repayment_Details


//Deposits Routes
Route::get('/deposits/add', [App\Http\Controllers\DepositsController::class, 'index'])->name('deposits/add')->middleware('auth');
Route::get('/deposits/all', [App\Http\Controllers\DepositsController::class, 'show'])->name('deposits/all')->middleware('auth');
Route::post('/post_deposit', [App\Http\Controllers\DepositsController::class, 'store'])->name('post_deposit');
Route::post('/Deposit_Details/{id}', [App\Http\Controllers\DepositsController::class, 'DepositDetails'])->name('Deposit_Details');

