<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // dd(Route::getRoutes()->getRoutes());
    return view('welcome');
});

Route::get('/login', function () {
    // dd(Route::getRoutes()->getRoutes());
    return view('welcome');
})->name('login');
