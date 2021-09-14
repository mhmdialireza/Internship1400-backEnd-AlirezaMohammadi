<?php

use App\Http\Controllers\V1\ApiResponseController;
use Illuminate\Support\Facades\Route;

Route::prefix('poly')->group(function () { 
    Route::post('',[ApiResponseController::class,'index']);
    Route::post('derivate',[ApiResponseController::class,'derivate']);
    Route::post('answerforvalue',[ApiResponseController::class,'answerForValue']);
    Route::post('sum',[ApiResponseController::class,'sum']);
    Route::post('sub',[ApiResponseController::class,'sub']);
    Route::post('mul',[ApiResponseController::class,'mul']);
});