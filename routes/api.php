<?php

use Illuminate\Http\Request;

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
    // Prefixed with /auth
    'prefix' => 'auth',
], function() {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    // Requires Authorization
    Route::group([
        'middleware' => 'jwt.auth'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('getUser', 'AuthController@getUser');
        Route::patch('password/change', 'AuthController@changePassword');
    });

    // Limit number of requests per seconds, configured in app/Http/Kernel.php
    Route::group([
        'middleware' => 'api',
    ], function () {
        Route::post('password/token/create', 'AuthController@createPasswordResetToken');
        Route::get('password/token/find/{token}', 'AuthController@findPasswordResetToken');
        Route::patch('password/reset', 'AuthController@resetPassword');
    });
});

Route::group([
    'prefix' => 'heros',
    'middleware' => 'jwt.auth'
], function() {
    Route::get('findall', 'HerosController@findAll');
    Route::get('/{id}', 'HerosController@findById');
    Route::get('/{id}/realname', 'HerosController@getRealname');
    Route::get('/{id}/heroname', 'HerosController@getHeroname');
    Route::get('/{id}/publisher', 'HerosController@getPublishername');
    Route::delete('/{id}/remove', 'HerosController@remove');
    Route::get('/{id}/affiliations', 'HerosController@getAffiliations');
    Route::get('/search/{name}', 'HerosController@searchByName');
    Route::post('create', 'HerosController@create');
    Route::put('/{id}/update', 'HerosController@update');

});

Route::group([
    'prefix' => 'affiliations',
    'middleware' => 'jwt.auth'
], function() {
    Route::post('/create', 'AffiliationController@create');
    Route::delete('{id}/remove', 'AffiliationController@remove');

});

