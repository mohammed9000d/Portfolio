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
    return view('welcome');
});

Route::prefix('cms/admin')->middleware('auth:admin')->group(function () {
    Route::view('/', 'admin.index')->name('admin.index');
    Route::view('/profile', 'admin.profile')->name('admin.profile');
    Route::view('/log', 'admin.auth.login');
});

Route::prefix('cms/admin')->middleware('auth:admin')->namespace('App\Http\Controllers')->group(function () {
    Route::resource('admins', 'AdminController');
    Route::resource('contacts', 'ContactController');
    Route::resource('projects', 'ProjectController');
    Route::get('/logout','Auth\AdminAuthController@logout')->name('admin.logout');
});

Route::prefix('cms/admin')->namespace('App\Http\Controllers')->group(function () {
    Route::get('/login', 'Auth\AdminAuthController@showLoginView')->name('admin.login_view');
    Route::post('/login','Auth\AdminAuthController@login')->name('admin.login');
});
