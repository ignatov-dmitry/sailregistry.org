<?php

use App\Classes\Transliteration;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\StudentsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    Route::get('/list', [StudentsController::class, 'index'])->middleware(['middleware' => 'role:super-admin,school-admin'])->name('list');
    Route::get('/{hash}', [StudentsController::class, 'showStudent'])->name('student');

    Route::get('/certificate/{user}/{group}', [StudentsController::class, 'showDataForCertificate'])
        ->middleware(['middleware' => 'role:super-admin,school-admin'])
        ->name('certificate_data');

    Route::post('/certificate/get/{user}', [StudentsController::class, 'toPdf'])
        ->middleware(['middleware' => 'role:super-admin,school-admin'])
        ->name('get_certificate');

    Route::get('/certificate/create/{user}/{group}', [StudentsController::class, 'createCertificate'])->middleware(
        ['middleware' => 'role:super-admin,school-admin']
    )->name('create_certificate');

    Route::post('/certificate/issue/{user}/{group}', [StudentsController::class, 'issueCertificate'])->name('issue_certificate');

    Route::get('/certificate/print/{user}/{certificate}', [StudentsController::class, 'showRusCertificateData'])->name('certificate_rus_data');

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

        Route::get('/user/create', [UserController::class, 'create'])->middleware(
            ['middleware' => 'role:super-admin,school-admin']
        )->name('create');

        Route::post('/user/store', [UserController::class, 'store'])->name('store')->middleware(
            ['middleware' => 'role:super-admin,school-admin']
        );

        Route::get('/user/show/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::post('/user/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/ajax/get_users_by_user_login', [UserController::class, 'getUsersByUserLogin']);
        Route::post('/user/{user}/send_credentials', [UserController::class, 'sendCredentials'])->name('send_credentials');

        Route::get('/transliterationNames', function (Request $request) {
            $transliteratedArray = [];
            $fields = $request->all();

            foreach ($fields as $key => $field) {
                if ($field == null) continue;
                $key = str_replace('ru', 'en', $key);
                $transliteratedArray[$key] = Transliteration::make($field, true);
            }

            return response()->json($transliteratedArray);
        });
    });


});

Route::get('/redirection/{old_id}', function ($old_id){
    return redirect('https://iytnet.com/certprofile/' . $old_id, 301);
})->name('redirectToIytnet');
