<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/member/{id}', [App\Http\Controllers\LoanApplicationController::class, 'get'])->name('member');


Route::post('/getUserbyid', [App\Http\Controllers\LoanApplicationController::class, 'getUserbyid']);
Route::post('/getLoantypes', [App\Http\Controllers\LoanApplicationController::class, 'getLoantypes']);

Route::post('/auth/register', [App\Http\Controllers\AuthController::class, 'register']);

Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function (Request $request) {
        return auth()->user();
    });
    Route::post('/auth/logout', [AuthController::class, 'logout']);
   
});


//mpesa
Route::post('validation', [App\Http\Controllers\MpesaTransactionController::class, 'validation']);
Route::post('confirmation', [App\Http\Controllers\MpesaTransactionController::class, 'confirmation_url']);
Route::get('accesstoken', [App\Http\Controllers\MpesaTransactionController::class, 'get_access_token']);
Route::post('stkpush', [App\Http\Controllers\MpesaTransactionController::class, 'customerMpesaSTKPush']);
Route::get('/members_details/{memberno}', [App\Http\Controllers\ApiController::class, 'membersdetails'])->name('members_details');
Route::get('/loandetails/{memberno}', [App\Http\Controllers\ApiController::class, 'loandetails'])->name('loandetails');


//loans
Route::post('/post_loanapplication', [App\Http\Controllers\ApiController::class, 'store'])->name('post_loanapplication');
Route::post('/loan/approve', [App\Http\Controllers\ApiController::class, 'approve'])->name('approve');
Route::post('/loan/destroy', [App\Http\Controllers\ApiController::class, 'destroy'])->name('destroy');
Route::get('/details', [App\Http\Controllers\ApiController::class, 'getAllDetails'])->name('/details'); 
Route::get('/myloan/{memberno}', [App\Http\Controllers\ApiController::class, 'getmyloan'])->name('/myloan'); 

Route::get('/loans/all', [App\Http\Controllers\ApiController::class, 'getAllLoans'])->name('loans/all'); 
Route::get('/deposits/all', [App\Http\Controllers\ApiController::class, 'getAllDeposits'])->name('deposits/all'); 
Route::get('/loans/approved', [App\Http\Controllers\ApiController::class, 'getAllApprovedLoans'])->name('loans/approved'); 
Route::get('/loans/rejected', [App\Http\Controllers\ApiController::class, 'getAllRejectedLoans'])->name('loans/rejected'); 
Route::get('/loans/pending', [App\Http\Controllers\ApiController::class, 'getAllPendingLoans'])->name('loans/pending'); 
