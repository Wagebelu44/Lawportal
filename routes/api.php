<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Api\LoginController@index')->name('login.index');
Route::post('/logout', 'Api\LoginController@logout')->name('login.endsession');

Route::middleware(["auth:sanctum"])->group(function () {
  Route::post('/attendence', 'Api\AttendenceController@index')->name('attendence.index');
  Route::get('/employee', 'Api\EmployeeController@index')->name('employee.index');
});


