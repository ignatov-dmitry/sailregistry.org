<?php

use App\Http\Controllers\LegacyController;
use App\Http\Controllers\StudentsController;
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

Route::group(['prefix' => 'legacy'], function (){
    Route::get('search', [LegacyController::class, 'search'])->name('legacy_search');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
    Route::get('/', [StudentsController::class, 'index'])->middleware(['middleware' => 'role:super-admin'])->name('list');
    Route::get('/{user}', [StudentsController::class, 'showStudent'])->name('student');
    Route::get('/certificate/{user}/{group}', [StudentsController::class, 'showDataForCertificate'])->middleware(['middleware' => 'role:super-admin'])->name('certificate_data');
    Route::post('/certificate/get/{user}', [StudentsController::class, 'toPdf'])->middleware(['middleware' => 'role:super-admin'])->name('get_certificate');
});

