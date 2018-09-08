<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth', 'as' => 'auth.',
    'namespace' => 'Api\Auth',
    'middleware' => 'api'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

    // Companies Resource
    Route::resource('companies', 'CompanyController', ['except' => ['create', 'edit']]);

    // Get list of provinces
    Route::get('provinces', 'AddressController@provinces');

    // Get list of districts by province id
    Route:: get('provinces/{id}', 'AddressController@province');

});

