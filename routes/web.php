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
    Route::post('getpagu', 'PaguController@getpagu')->name('pagu.getpagu');
    Route::get('definitif', 'PaguController@definitif')->name('pagu.definitif');
    Route::get('prioritas', 'PaguController@prioritas')->name('pagu.prioritas');
    Route::post('hapus_prioritas', 'PaguController@hapus_prioritas')->name('pagu.hapus_prioritas');
    Route::get('hapus', 'PaguController@hapus')->name('pagu.hapus');

    Route::get('anggaran', 'PaguController@anggaran')->name('pagu.anggaran');
    Route::get('lokasi', 'PaguController@alokasi')->name('pagu.alokasi');
    Route::get('revisi', 'PaguController@revisi')->name('pagu.revisi');

    Route::resource('pagu', 'PaguController');

    // Usulan
    Route::group(['as' => 'usulan.', 'prefix' => 'usulan', 'namespace' => 'Usulan'], function () {

        // Kenaikan Kelas PA
        Route::group(['as' => 'kenaikankelaspa.', 'prefix' => 'kenaikankelaspa'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'KenaikanKelasPaController@table']);
        });
        Route::resource('kenaikankelaspa', 'KenaikanKelasPaController');

        // Kenaikan Kelas PN
        Route::group(['as' => 'kenaikankelaspn.', 'prefix' => 'kenaikankelaspn'], function () {
            Route::post('table', ['as' => 'table', 'uses' => 'KenaikanKelasPnController@table']);
        });
        Route::resource('kenaikankelaspn', 'KenaikanKelasPnController');

    });

    // Baseline 1
    Route::get('baseline1/dakung/{param?}', 'Baseline1Controller@dakung')->name('baseline1.dakung');
    Route::post('baseline1/pagu', 'Baseline1Controller@pagu')->name('baseline1.pagu');
    Route::post('baseline1/uploads', 'Baseline1Controller@uploads')->name('baseline1.uploads');
    Route::resource('baseline1', 'Baseline1Controller');

    // Baseline 3
    Route::get('baseline3/rincian/{id?}', 'Baseline3Controller@rincian')->name('baseline3.rincian');
    Route::get('baseline3/dakung/{id?}', 'Baseline3Controller@dakung')->name('baseline3.dakung');
    Route::post('baseline3/uploads', 'Baseline3Controller@uploads')->name('baseline3.uploads');
    Route::post('baseline3/pagu', 'Baseline3Controller@pagu')->name('baseline3.pagu');
    Route::resource('baseline3', 'Baseline3Controller');

    // Pagu Indikatif
    //Route::get('indikatif', 'PaguController@indikatif')->name('pagu.indikatif');

    Route::get('paguindikatif/dakung/{id?}', 'PaguIndikatifController@dakung')->name('paguindikatif.dakung');
    Route::post('paguindikatif/uploads', 'PaguIndikatifController@uploads')->name('paguindikatif.uploads');
    Route::resource('paguindikatif', 'PaguIndikatifController');
});


// Logs
Route::get('logs/hapussemua','LogsController@hapussemua')->name('logs.hapussemua');
Route::resource('logs', 'LogsController');


// Route API
Route::group(['as'=>'api.','prefix'=>'api','middleware'=>['auth','verified']], function (){
    Route::get('user', 'ApiController@apiUser')->name('user');
    Route::get('satker', 'ApiController@apiSatker')->name('satker');
    Route::get('pagu', 'ApiController@apiPagu')->name('pagu');
    Route::get('prioritas', 'ApiController@apiPrioritas')->name('prioritas');

    // usulan kenaikan kelas PA
    Route::get('usulankenaikankelaspa', 'ApiController@apiUsulanKenaikanKelasPa')->name('usulankenaikankelaspa');
 
    // Baseline 1
    Route::get('baseline1', 'ApiController@apiBaseline1')->name('baseline1');
    Route::get('pagubaseline1', 'ApiController@apiPaguBaseline1')->name('pagubaseline1');
    Route::get('dakungbaseline1', 'ApiController@apiDakungBaseline1')->name('dakungbaseline1');

    // Baseline 3
    Route::get('baseline3', 'ApiController@apiBaseline3')->name('baseline3');
    Route::get('pagubaseline3', 'ApiController@apiPaguBaseline3')->name('pagubaseline3');
    Route::get('databaseline3', 'ApiController@apiDataBaseline3')->name('databaseline3');
    Route::get('dakungbaseline3', 'ApiController@apiDakungBaseline3')->name('dakungbaseline3');

    // Indikatif
    Route::get('indikatif', 'ApiController@apiIndikatif')->name('indikatif');
    Route::get('rincianindikatif', 'ApiController@apiRincianIndikatif')->name('rincianindikatif');
    Route::get('dakungindikatif', 'ApiController@apiDakungIndikatif')->name('dakungindikatif');
});