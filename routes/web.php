<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\VendedoresController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::group(['prefix'=>'cliente','as'=>'cliente.'], function(){
    Route::get('/', 'ClienteController@index');
    Route::get('/{id}', 'ClienteController@show');
    Route::post('/', 'ClienteController@store');
    Route::put('/{id}', 'ClienteController@update');
    Route::delete('/{id}', 'ClienteController@destroy');
});

Route::group(['prefix'=>'vendedor','as'=>'vendedor.'], function(){
    Route::get('/', 'VendedoresController@index');
    Route::get('/{id}', 'VendedoresController@show');
    Route::post('/', 'VendedoresController@store');
    Route::put('/', 'VendedoresController@update');
    Route::delete('/', 'VendedoresController@destroy');
});

Route::group(['prefix'=>'carteira','as'=>'carteira.'], function(){
    Route::get('/', 'CarteiraController@index');
    Route::post('/', 'CarteiraController@store');
    Route::get('/vendedor/{id}', 'CarteiraController@vendedor');
});
