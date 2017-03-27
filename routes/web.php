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

/************ STUDENT ROUTES ************/

Route::get('/', function() {
    return view('student/welcome');
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
])->middleware('auth');

/************ ADMIN ROUTES ************/

Route::group(['prefix' => 'admin'], function()
{
    Route::get('/', function() {
        return view('admin/welcome');
    });
    
    Route::get('/students', [
        'uses' => 'Admin\StudentController@index',
        'as' => 'admin.students'
    ]);
    
    Route::post('/students', [
        'uses' => 'Admin\StudentController@index',
        'as' => 'admin.students'
    ]);
});

// to jest strefa dla Mateusza i Grzesia do testowania pojedynczych widoków. Proszę tu nie grzebać, poza nimi dwoma
// Oni są panami tej strefy i tu może być szyf taki jaki zrobią, Poźniej to im skasujemy.
//-------------------------------------------------------------------------------------------------------------------------


Route::group(['prefix' => 'testowanie'], function() {

Route::get('/sb', function() {
    return view('student.selectableSubject');
});
});

//-------------------------------------------------------------------------------------------------------------------------

