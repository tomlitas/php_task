<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;

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

// Route::get('/', function () {
//     return view('index');
// });

Route::redirect('/', 'project');
Route::resource('project', ProjectController::class);

Route::get('/index{id}',[StudentController::class,'index'])->name('student.index');
Route::get('/create',[StudentController::class,'create'])->name('student.create');
Route::post('/store',[StudentController::class,'store'])->name('student.store');

Route::post('student', [StudentController::class, 'assign'])->name('student.assign');
Route::post('/destroy/{id}',[StudentController::class,'destroy'])->name('destroy');
