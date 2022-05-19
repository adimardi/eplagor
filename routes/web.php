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

Route::get('logout', 'Auth\LoginController@logout');
Route::get('/home', 'DashboardController@index')->name('home');
Route::get('/', 'HomeController@index')->name('landing');

// login
Auth::routes();
// verifikasi email
Auth::routes(['verify' => true]);

//Home

Route::group(['middleware'=>['auth','verified','admin']], function (){

    // user
    Route::post('user/import_excel', 'UserController@import_excel')->name('user.import');
    Route::post('hapusUser', 'UserController@hapus')->name('user.hapus');
    Route::resource('user', 'UserController');

    // Satker
    Route::resource('satker', 'SatkerController');

});


Route::group(['middleware'=>['auth','verified']], function (){

    // Pagu
    Route::resource('pagu', 'PaguController');

});


// Logs
Route::get('logs/hapussemua','LogsController@hapussemua')->name('logs.hapussemua');
Route::resource('logs', 'LogsController');


// Route API
Route::group(['as'=>'api.','prefix'=>'api','middleware'=>['auth','verified']], function (){
    Route::get('user', 'ApiController@apiUser')->name('user');
    Route::get('satker', 'ApiController@apiSatker')->name('satker');
    Route::get('pagu', 'ApiController@apiPagu')->name('pagu');
});