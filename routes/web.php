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

Route::get('/', 'LandingController@index')->name('home');

Route::get('/signin', 'AuthController@showFormLogin')->name('login');
Route::post('/signin', 'AuthController@postLogin')->name('post.login');

Route::group(['middleware' => ['auth', 'revalidate']], function() {
    Route::get('/panel', 'AdminController@home');
});

Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'revalidate']], function() {
    Route::get('/dashboard', 'AdminController@home')->name('admin.panel');

    Route::get('/slide', 'SlideController@index')->name('slide.banner');
    Route::post('/slide', 'SlideController@store')->name('slide.post');
    Route::post('/slide/data', 'SlideController@data')->name('slide.data');
    Route::get('/slide/{id}', 'SlideController@edit')->name('slide.edit');
    Route::put('/slide', 'SlideController@update')->name('slide.update');
    Route::get('/slide/status/{id}', 'SlideController@update_status')->name('slide.status');
    Route::delete('/slide', 'SlideController@destroy')->name('slide.delete');

    Route::get('/artikel', 'ArtikelController@index')->name('panel.artikel');

    Route::get('/pengumuman', 'PengumumanController@index')->name('panel.pengumuman');
    Route::post('/pengumuman', 'PengumumanController@store')->name('pengumuman.post');
    Route::post('/pengumuman/data', 'PengumumanController@data')->name('pengumuman.data');
    Route::get('/pengumuman/{id}', 'PengumumanController@show')->name('pengumuman.show');
    Route::put('/pengumuman', 'PengumumanController@update')->name('pengumuman.update');
    Route::delete('/pengumuman', 'PengumumanController@destroy')->name('pengumuman.delete');

    Route::get('/signout', 'AuthController@signout')->name('signout');
});

Route::resource('image', 'ImageController');