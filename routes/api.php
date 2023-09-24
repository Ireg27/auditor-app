<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ScheduleJobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('schedule-jobs', [ScheduleJobController::class, 'index']);
    Route::post('schedule-jobs', [ScheduleJobController::class, 'store']);
    Route::get('schedule-jobs/{schedule_job}', [ScheduleJobController::class, 'show']);

    Route::patch('schedule-jobs/{scheduleJob}/assign', [ScheduleJobController::class, 'assignJob']);
    Route::patch('schedule-jobs/{scheduleJob}/complete', [ScheduleJobController::class, 'completeJob']);
});
