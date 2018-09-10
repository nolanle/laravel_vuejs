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
    Route::get('me', 'AuthController@me');
});

Route::group([
    'prefix' => '/v1', 'as' => 'api.',
    'namespace' => 'Api\V1',
    'middleware' => ['api', 'auth:api']
], function () {

    // Get Dashboard
    Route::get('dashboard', 'DashboardController@index');

    // Get Activities
    Route::get('activities', 'AccountController@activities');

    // Companies Resource
    Route::get('companies-without-paginate', 'CompanyController@indexWithoutPaginate');
    Route::apiResource('companies', 'CompanyController');

    // Customers Resource
    Route::apiResource('customers', 'CustomerController');

    // Get list of provinces
    Route::get('provinces', 'AddressController@provinces');

    // Get list of districts by province id
    Route:: get('provinces/{id}', 'AddressController@province');

});

