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
Route::get('/loans/all', [App\Http\Controllers\LoanApplicationController::class, 'show'])->name('loans/all'); 
Route::get('/details', [App\Http\Controllers\ApiController::class, 'getAllDetails'])->name('/details'); 

