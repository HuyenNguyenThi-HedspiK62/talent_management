<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::prefix('schedule')->name('schedule.')->group(function () {
    Route::get('/delete/{scheduleId}', [App\Http\Controllers\ScheduleController::class, 'delete'])->name('delete');
    Route::get('/{option}', [App\Http\Controllers\ScheduleController::class, 'index'])->name('index');
    Route::get('/{scheduleId}/{userId}', [App\Http\Controllers\ScheduleController::class, 'show'])->name('show');
});

Route::prefix('course')->name('course.')->group(function () {
    Route::get('/', function (){
        return view('course.index');
    })->name('index');
    Route::get('/show', [App\Http\Controllers\CourseController::class, 'show'])->name('show');
    Route::get('/edit', [App\Http\Controllers\CourseController::class, 'edit'])->name('edit');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('talent')->name('talent.')->group(function () {
    Route::get('/delete/{talentId}', [App\Http\Controllers\TalentController::class, 'delete'])->name('delete');
    Route::get('/', [App\Http\Controllers\TalentController::class, 'index'])->name('index');
    Route::get('/{talent}/{option}', [App\Http\Controllers\TalentController::class, 'show'])->name('show');
});

Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('/', [App\Http\Controllers\TalentController::class, 'indexManager'])->name('index');
});

Route::get('/add-course', [App\Http\Controllers\CourseController::class, 'addCourse'])->name('course.add');


Route::get('/add-schedule', [App\Http\Controllers\ScheduleController::class, 'addSchedule'])->name('schedule.add');
Route::post('/store-schedule/{option}', [App\Http\Controllers\ScheduleController::class, 'store'])->name('schedule.store');
Route::get('/edit-schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'editSchedule'])->name('schedule.edit');
Route::post('/{id}/update-schedule', [App\Http\Controllers\ScheduleController::class, 'update'])->name('schedule.update');
Route::post('/store-talent', [App\Http\Controllers\TalentController::class, 'store'])->name('talent.store');
Route::get('/add-talent', [App\Http\Controllers\TalentController::class, 'addTalent'])->name('talent.add');
Route::get('/{id}/edit-talent', [App\Http\Controllers\TalentController::class, 'editTalent'])->name('talent.edit');
Route::post('/{id}/update-talent/{option}', [App\Http\Controllers\TalentController::class, 'update'])->name('talent.update');
