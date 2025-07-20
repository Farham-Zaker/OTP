<?php

use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

Route::post("/otp/send", [OTPController::class, "send"]);
Route::post("/otp/verify");
