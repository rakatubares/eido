<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::post('roles/list','RoleController@lists')->name('roles.list');
    Route::resource('users','UserController');
    Route::post('users/all','UserController@lists')->name('users.all');

    Route::get('importasi','ImporController@index')->name('impor.index');
    Route::post('importasi/list','ImporController@list')->name('impor.list');
    Route::post('importasi','ImporController@store')->name('impor.store');
    Route::get('importasi/{impor}','ImporController@show')->name('impor.show');
    Route::get('importasi/{impor}/detail','ImporController@detail')->name('impor.detail');
    Route::post('importasi/{impor}/update','ImporController@update')->name('impor.update');
    Route::delete('importasi/{impor}','ImporController@destroy')->name('impor.destroy');
    Route::post('importasi/options','ImporController@displayOptions')->name('impor.options');

    Route::get('status/{impor}','StatusController@list')->name('status.list');
    Route::post('status/{impor}','StatusController@store')->name('status.store');

    Route::get('dashboard/total','DashboardController@total')->name('dashboard.total');

    Route::get('covid','CovidSoettaController@index')->name('covid.index');
    Route::get('covid/list','CovidSoettaController@list')->name('covid.list');
    Route::get('covid/{id_covid}','CovidSoettaController@show')->name('covid.show');
    Route::post('covid/{id_covid}/monitor','CovidSoettaController@monitor')->name('covid.monitor');
    Route::get('covid_all','CovidSoettaController@index_all')->name('covid.all');
    Route::get('covid_all/list','CovidSoettaController@list_all')->name('covid.all_list');
});