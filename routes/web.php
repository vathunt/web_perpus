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

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/signin', 'AuthController@showFormLogin')->name('login');
Route::post('/signin', 'AuthController@postLogin')->name('post.login');

Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'revalidate']], function() {
    Route::get('/dashboard', 'AdminController@home')->name('admin.panel');

    Route::get('/slide', 'SlideController@index')->name('slide.banner');
    Route::post('/slide', 'SlideController@store')->name('slide.post');
    Route::post('/slide/data', 'SlideController@data')->name('slide.data');

    Route::get('/artikel', 'AdminController@artikel')->name('artikel');
    Route::get('/signout', 'AuthController@signout')->name('signout');
});

// Route::resource('image', 'ImageController');