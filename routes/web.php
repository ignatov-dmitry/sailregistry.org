<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\UserController;
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

Route::group(['prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('/list', [StudentsController::class, 'index'])->middleware(['middleware' => 'role:super-admin'])->name('list');
    Route::get('/{hash}', [StudentsController::class, 'showStudent'])->name('student');
    Route::get('/certificate/{user}/{group}', [StudentsController::class, 'showDataForCertificate'])->middleware(['middleware' => 'role:super-admin'])->name('certificate_data');
    Route::post('/certificate/get/{user}', [StudentsController::class, 'toPdf'])->middleware(['middleware' => 'role:super-admin'])->name('get_certificate');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::group(['prefix' => 'certificates', 'as' => 'certificates.'], function () {
        Route::get('/', [CertificateController::class, 'index'])->name('certificates');
        Route::get('/certificate/create', [CertificateController::class, 'create'])->name('create');
        Route::post('/certificate/store', [CertificateController::class, 'store'])->name('store');
        Route::get('/certificate/edit/{certificateType}', [CertificateController::class, 'edit'])->name('edit');
        Route::post('/certificate/update/{certificateType}', [CertificateController::class, 'update'])->name('update');
        Route::delete('/certificate/edit', [CertificateController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'schools', 'as' => 'schools.'], function () {
        Route::get('/', [SchoolController::class, 'index'])->name('schools');
        Route::get('/school/create', [SchoolController::class, 'create'])->name('create');
        Route::post('/school/store', [SchoolController::class, 'store'])->name('store');
        Route::get('/school/edit/{school}', [SchoolController::class, 'edit'])->name('edit');
        Route::post('/school/update/{school}', [SchoolController::class, 'update'])->name('update');
        Route::delete('/school/edit', [SchoolController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
        Route::get('/', [CountryController::class, 'index'])->name('countries');
        Route::get('/country/create', [CountryController::class, 'create'])->name('create');
        Route::post('/country/store', [CountryController::class, 'store'])->name('store');
        Route::get('/country/edit/{country}', [CountryController::class, 'edit'])->name('edit');
        Route::post('/country/update/{country}', [CountryController::class, 'update'])->name('update');
        Route::delete('/country/destroy/{country}', [CountryController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/user/create', [UserController::class, 'create'])->name('create');
        Route::post('/user/store', [UserController::class, 'store'])->name('store');
        Route::get('/user/show/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::post('/user/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/ajax/get_users_by_user_login', [UserController::class, 'getUsersByUserLogin']);
        Route::post('/user/{user}/send_credentials', [UserController::class, 'sendCredentials'])->name('send_credentials');
    });
});
