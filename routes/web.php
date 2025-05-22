<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubmitTSMNotesController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\ActivityLogController;


Route::get('/', function () { return view('login'); })->name('login');
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/adminlogin', function () { return view('adminlogin'); })->name('adminlogin');
Route::get('/upload', function () { return view('upload'); })->name('upload');
Route::get('/admin', function () {return view('admin'); })->name('admin');
Route::get('/accounts', function () {return view('accounts'); })->name('accounts');
Route::get('/activity', function () {return view('activity'); })->name('activity');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/users', [AuthController::class, 'getAllUsers']);
Route::put('/user/{id}/suspend', [AuthController::class, 'suspend']);
Route::put('/user/{id}/enable', [AuthController::class, 'enable']);
Route::delete('/user/{id}', [AuthController::class, 'delete']);


Route::get('/activities', [ActivityLogController::class, 'getAllActivityLogs']);


Route::post('/adminregister', [AdminLoginController::class, 'register']);
Route::post('/adminlogin', [AdminLoginController::class, 'login']);

Route::post('/submit-tsm-notes', [SubmitTSMNotesController::class, 'submitTSMNotes']);
//for Activity log
Route::get('/tsm-notes/all', [SubmitTSMNotesController::class, 'tsmNotes']);


