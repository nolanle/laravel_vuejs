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
    Route::get('permissions', 'AuthController@permissions');
    Route::get('check/permission/{name}', 'AuthController@checkPermission');
});

Route::group([
    'prefix' => '/v1', 'as' => 'api.',
    'namespace' => 'Api\V1',
    'middleware' => ['api', 'auth:api']
], function () {

    // Get Dashboard
    Route::get('dashboard', 'DashboardController@index');

    // Get Activities
    Route::get('activities', 'ActivityController@activities');

    // Change company id
    Route::match(['put', 'patch'], 'change-company', 'AccountController@changeCompany');

    // Companies Resource
    Route::get('companies-without-paginate', 'CompanyController@indexWithoutPaginate');
    Route::get('header-companies', 'CompanyController@indexHeaderCompanies');
    Route::apiResource('companies', 'CompanyController');

    // Customers Resource
    Route::get('customers-without-paginate', 'CustomerController@indexWithoutPaginate');
    Route::post('customers-search', 'CustomerController@search');
    Route::apiResource('customers', 'CustomerController');

    // Employees Resource
    Route::apiResource('employees', 'EmployeeController');

    // Commodities Resource
    Route::get('commodities-without-paginate', 'CommodityController@indexWithoutPaginate');
    Route::apiResource('commodities', 'CommodityController');

    // Contracts Resource
    Route::match(['put', 'patch'], 'contracts/paid/{id}', 'ContractController@paid');
    Route::match(['put', 'patch'], 'contracts/renew/{id}', 'ContractController@renew');
    Route::match(['put', 'patch'], 'contracts/liquidate/{id}', 'ContractController@liquidate');

    Route::get('contracts/warning', 'ContractController@listOfWarning');
    Route::apiResource('contracts', 'ContractController');

    // Roles Resource
    Route::get('roles-without-paginate', 'RoleController@indexWithoutPaginate');
    Route::apiResource('roles', 'RoleController');

    // Get list of provinces
    Route::get('provinces', 'AddressController@provinces');

    // Get list of districts by province id
    Route:: get('provinces/{id}', 'AddressController@province');

});

