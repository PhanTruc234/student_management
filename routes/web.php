<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::resource('students', StudentController::class);
Route::resource('subjects', SubjectController::class);
Route::prefix('students/{student}')->name('students.')->group(function () {
    Route::resource('scores', ScoreController::class);
    Route::resource('attendances', AttendanceController::class);
});
