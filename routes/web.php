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

// Route Dashboard
Route::get('/', 'LandingController@index')->name('home');

// Route Halaman Login Administrator
Route::get('/signin', 'AuthController@showFormLogin')->name('login');
Route::post('/signin', 'AuthController@postLogin')->name('post.login');

// Route Panel Administrator
Route::group(['middleware' => ['auth', 'revalidate']], function () {
    Route::get('/panel', 'AdminController@home');
});

// Route Panel Administrator
Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'revalidate']], function () {
    // Route Panel Dashboard Administrator
    Route::get('/dashboard', 'AdminController@home')->name('admin.panel');

    // Route Panel Slide Banner Administrator
    Route::get('/slide', 'SlideController@index')->name('slide.banner');
    Route::post('/slide', 'SlideController@store')->name('slide.post');
    Route::post('/slide/data', 'SlideController@data')->name('slide.data');
    Route::get('/slide/{id}', 'SlideController@edit')->name('slide.edit');
    Route::put('/slide', 'SlideController@update')->name('slide.update');
    Route::get('/slide/status/{id}', 'SlideController@update_status')->name('slide.status');
    Route::delete('/slide', 'SlideController@destroy')->name('slide.delete');

    // Route Panel Artikel Administrator
    Route::get('/artikel', 'ArtikelController@index')->name('panel.artikel');
    Route::post('/artikel/data', 'ArtikelController@data')->name('artikel.data');
    Route::post('/artikel', 'ArtikelController@store')->name('artikel.post');
    Route::get('/artikel/{id}', 'ArtikelController@show')->name('artikel.show');
    Route::put('/artikel', 'ArtikelController@update')->name('artikel.update');
    Route::delete('/artikel', 'ArtikelController@destroy')->name('artikel.delete');

    // Route Panel Berita Administrator
    Route::get('/berita', 'BeritaController@index')->name('panel.berita');
    Route::post('/berita', 'BeritaController@store')->name('berita.post');
    Route::post('/berita/data', 'BeritaController@data')->name('berita.data');
    Route::get('/berita/{id}', 'BeritaController@show')->name('berita.show');
    Route::put('/berita', 'BeritaController@update')->name('berita.update');
    Route::delete('/berita', 'BeritaController@destroy')->name('berita.delete');

    // Route Panel Pengumuman Administrator
    Route::get('/pengumuman', 'PengumumanController@index')->name('panel.pengumuman');
    Route::post('/pengumuman', 'PengumumanController@store')->name('pengumuman.post');
    Route::post('/pengumuman/data', 'PengumumanController@data')->name('pengumuman.data');
    Route::get('/pengumuman/{id}', 'PengumumanController@show')->name('pengumuman.show');
    Route::put('/pengumuman', 'PengumumanController@update')->name('pengumuman.update');
    Route::delete('/pengumuman', 'PengumumanController@destroy')->name('pengumuman.delete');

    // Route Upload dan Remove Gambar Text Editor
    Route::post('/pengumuman/upload', 'ImageController@upload_image')->name('upload.gambar.editor');
    Route::post('/pengumuman/remove', 'ImageController@remove_image')->name('remove.gambar.editor');

    // Route Logout Administrator
    Route::get('/signout', 'AuthController@signout')->name('signout');
});

// Route::resource('image', 'ImageController');
// Route::post('image/upload', 'ImageController@upload_image')->name('upload_gambar');