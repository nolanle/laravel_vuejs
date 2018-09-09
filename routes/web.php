<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Auth::routes();

// Homepage Route
Route::get('/', function () { return redirect(\route('main')); });

// Single Page Application
Route::get('/main', function () {
    return view('main');
})->name('main');

// Administrator Routes
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    // Administrator Admin Route
    Route::get('/', 'AdminController@index')->name('index');

    // Logout Route
    Route::get('logout', function () {
        Auth::logout();
    });

});
