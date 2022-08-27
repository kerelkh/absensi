<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DinasController;
use App\Http\Controllers\KepegawaianController;
use App\Http\Controllers\SuperController;

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

Route::middleware(['guest'])->group(function() {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', "check.role:6"])->group(function() {
    Route::get('/', [UserController::class, 'index']);
});

Route::middleware(['auth', "check.role:1"])->group(function() {
    Route::get('/opd', [AdminController::class, 'index']);
    Route::get('/opd/addopd', [AdminController::class, 'newOpd']);
    Route::post('/opd/addopd', [AdminController::class, 'storeOpd']);
    Route::get('/opd/{slug}/edit', [AdminController::class, 'edit']);
    Route::put('/opd/{slug}/edit', [AdminController::class, 'storeEdit']);
    Route::delete('/opd/{slug}/edit', [AdminController::class, 'destroyOpd']);
});

Route::middleware(['auth', "check.role:2"])->group(function() {
    Route::get('/admin/kepegawaian', [KepegawaianController::class, 'index']);

    //users
    Route::get('/admin/kepegawaian/users', [KepegawaianController::class, 'users']);
    Route::get('/admin/kepegawaian/adduser', [KepegawaianController::class, 'formUser']);
    Route::post('/admin/kepegawaian/adduser', [KepegawaianController::class, 'storeUser']);
    Route::get('/admin/kepegawaian/{email}/edit', [KepegawaianController::class, 'showEdit']);
    Route::put('/admin/kepegawaian/{email}/edit', [KepegawaianController::class, 'storeEdit']);
    Route::put('/admin/kepegawaian/{email}/edit/opd', [KepegawaianController::class, 'updateOpd']);
    Route::put('/admin/kepegawaian/{email}/edit/password', [KepegawaianController::class, 'updatePassword']);
    Route::put('/admin/kepegawaian/{email}/edit/detail', [KepegawaianController::class, 'updateDetail']);
    Route::put('/admin/kepegawaian/{email}/edit/validation', [KepegawaianController::class, 'updateValidation']);

    //admin dinas
    Route::get('/admin/kepegawaian/admins', [KepegawaianController::class, 'admins']);
    Route::get('/admin/kepegawaian/addadmin', [KepegawaianController::class, 'formAdmin']);
    Route::post('/admin/kepegawaian/addadmin', [KepegawaianController::class, 'storeNewAdmin']);
    Route::get('/admin/kepegawaian/admins/{email}/edit', [KepegawaianController::class, 'showEditAdmin']);
    Route::put('/admin/kepegawaian/admins/{email}/edit', [KepegawaianController::class, 'storeUpdateAdmin']);
    Route::put("/admin/kepegawaian/admins/{email}/edit/password", [KepegawaianController::class, 'updatePassword']);
    Route::delete('/admin/kepegawaian/admins/{email}/edit', [KepegawaianController::class, 'deleteAdmin']);

    //news
    Route::get('/admin/kepegawaian/news', [KepegawaianController::class, 'news']);
    Route::post('/admin/kepegawaian/news', [KepegawaianController::class, 'storeNews']);
    Route::get('/admin/kepegawaian/news/{slug}/edit', [KepegawaianController::class, 'editNews']);
    Route::put('/admin/kepegawaian/news/{slug}/edit', [KepegawaianController::class, 'updateNews']);
});

Route::middleware(['auth', "check.role:3"])->group(function() {
    Route::get('/admin/dinas', [DinasController::class, 'index']);
    Route::put('/admin/dinas/{id}/valid', [DinasController::class, 'updateValidAbsen']);
    Route::get('/admin/dinas/searchuser', [DinasController::class, 'searchUser']);
    Route::get('/admin/dinas/users', [DinasController::class, 'users']);
    Route::get('/admin/dinas/{email}/show', [DinasController::class, 'detailUser']);
    Route::get('/admin/dinas/{email}/edit', [DinasController::class, 'showUser']);
    Route::put('/admin/dinas/{email}/edit', [DinasController::class, 'updateOpd']);
    Route::delete('/admin/dinas/users/{email}', [DinasController::class, 'deleteFromOpd']);
});

Route::fallback(function() {
    return redirect('/');
});
