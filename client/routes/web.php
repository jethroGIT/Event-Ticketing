<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventSessionController;
use App\Http\Controllers\RegistrasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('checkLogin')->group(function () {
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/events/{id}/sessions', [EventSessionController::class, 'index'])->name('sessions.index');
    Route::post('/events/{id}/sessions', [EventSessionController::class, 'store'])->name('sessions.store');
    Route::put('/events/sessions/{id}', [EventSessionController::class, 'update'])->name('sessions.update');
    Route::delete('/events/sessions/{id}', [EventSessionController::class, 'destroy'])->name('sessions.destroy');

    Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');
    Route::post('/registrasi', [RegistrasiController::class, 'registrasi'])->name('registrasi');
    Route::get('/registrasi/{id}/event/{event_id}', [RegistrasiController::class, 'konfirmasi'])->name('registrasi.pembayaran');
    Route::post('/registrasi/{id}/event', [RegistrasiController::class, 'storePembayaran'])->name('registrasi.store');
    Route::delete('/registrasi/{id}/event', [RegistrasiController::class, 'destroyKonfirmasi'])->name('registrasi.destroy');
    
});


Route::middleware('checkLogin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});




