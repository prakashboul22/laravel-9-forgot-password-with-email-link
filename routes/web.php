<?php

use App\Http\Controllers\ForgetPassController;
use Illuminate\Support\Facades\Route;



Route::get('/', [ForgetPassController::class, 'index'])->name('reset');
Route::post('/forget', [ForgetPassController::class, 'forgotpasswordmailSend'])->name('forgotpasswordmailSend');
Route::get('/updatepassword/{email}/{token}', [ForgetPassController::class, 'updatepassword'])->name('updatepassword');
Route::post('/reset', [ForgetPassController::class, 'passwordreset'])->name('auth.passwordreset');
