<?php

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


Route::get('/', function() {
    return view('welcome');
});

Route::post('/login', [
    'uses' => 'Student\LoginController@loginStudent',
    'as' => 'student.login'
]);

Route::post('/logout', [
    'uses' => 'Student\LoginController@logoutStudent',
    'as' => 'student.logout'
]);

Route::get('/dashboard', [
    'uses' => 'Student\DashboardController@index',
    'as' => 'student.dashboard'
]);

