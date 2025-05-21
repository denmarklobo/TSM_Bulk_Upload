<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmitTSMNotesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ActivityLogController;
 

Route::prefix('api')->group(function () {
    Route::post('/submit-tsm-notes', [SubmitTSMNotesController::class, 'submitTSMNotes']);
    Route::get('/tsm-notes/all', [SubmitTSMNotesController::class, 'tsmNotes']);

});

Route::middleware('auth:sanctum')->post('/userlogout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/admin/logout', [AuthController::class, 'adminLogout']);


Route::post('/login', [AuthController::class, 'login']);
Route::post('user/register', [AuthController::class, 'register']);
Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::put('/user/{id}/suspend', [AuthController::class, 'suspend']);
Route::put('/user/{id}/enable', [AuthController::class, 'enable']);
Route::delete('/user/{id}', [AuthController::class, 'put']);


Route::get('/activities', [ActivityLogController::class, 'getAllActivityLogs']);

Route::post('/adminregister', [AdminLoginController::class, 'register']);
Route::post('/adminlogin', [AdminLoginController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
