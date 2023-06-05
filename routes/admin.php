<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;


Route::group(['prefix' => '/v1'], function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    // Route::get('export', 'UserController@export');

    Route::post('createAdmin', [UserController::class, 'createAdmin']);


});
Route::group(['prefix' => '/v1', 'middleware' => ['auth:admin-api']], function () {

    Route::get('self', 'UserController@self');
    Route::get('user', 'UserController@index');
 

    Route::post('add-student', 'UserController@addRegister');
    Route::get('get-student', 'UserController@displayStudent');
    Route::get('get-IT', 'UserController@displayIT');
    Route::get('get-CRIM', 'UserController@displayCrim');
    Route::get('get-HM', 'UserController@displayHM');
    Route::get('get-ED', 'UserController@displayED');
    Route::get('get-CS', 'UserController@displayCS');
    Route::post('edit-student/{id}', 'UserController@editStudent');

    Route::post('insert-subjects', 'RecordController@store');


    Route::get('display-subjects', 'UserController@displaySubjects');
    Route::post('export', 'UserController@export');
    Route::post('exportbyprogram', 'UserController@exportByProgram');
    Route::post('exportList', 'UserController@exportList');
});
