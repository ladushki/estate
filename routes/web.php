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

Route::redirect('/', '/listing/sale');
Route::redirect('/listing', '/listing/sale');

Route::get('/import', '\App\Http\Controllers\ImportController@index')->name('import.index');
Route::get('/import/run', '\App\Http\Controllers\ImportController@run')->name('import.run');
Route::get('/listing/{product}', array('as' => 'listing', 'uses' => 'ListingController@index'))
    ->where('type', '(rent|sale)');

Route::get('/admin/edit/{id}', array('as' => 'edit', 'uses' => 'ListingController@edit'));
Route::post('/admin/edit/{id}', array('as' => 'edit', 'uses' => 'ListingController@edit'));
Route::post('/admin/update', array('as' => 'admin.update', 'uses' => 'ListingController@update'));
Route::get('/admin/show/{id}', array('as' => 'admin.show', 'uses' => 'ListingController@show'));

Route::get('/admin/vue/edit/{id}', array('as' => 'vue-edit', 'uses' => 'PropertyController@edit'));
Route::post('/admin/process/{id}', array('as' => 'process', 'uses' => 'PropertyController@process'));
Route::post('/admin/upload/', array('as' => 'process', 'uses' => 'PropertyController@upload'));

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
