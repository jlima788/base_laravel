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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'middleware' => 'auth',
    'as' => 'admin.',
    'prefix' => env('APP_ADMIN', 'admin'),
    'namespace' => 'Admin'
], function () {
    Route::get('/', 'HomeController@index');
    Route::group([
        'as' => 'user.',
        'alias' => 'user',
        'prefix' => 'user',
        'namespace' => 'User'
    ], function () {
        Route::resource('user', 'UserController')->middleware('can:usuario');
        Route::resource('role', 'RoleController')->middleware('can:grupo');
        Route::resource('profile', 'ProfileController');
    });

    Route::resource('store', 'StoreController')->middleware('can:super admin');
    Route::resource('mystore', 'MyStoreController')->middleware('can:loja');
});

Auth::routes(['register' => false]);

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');
