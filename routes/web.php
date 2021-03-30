<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAssignee;
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

Auth::routes(['register' => false]);
	
Route::get('/', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile', 'ProfileController@update')->name('profile.update');
Route::post('/auth_check', 'Auth\LoginController@authenticate')->name('auth.check');

Route::resource('user', 'UserController');
Route::resource('userrole', 'UserRoleController');

//middleware
Route::resource('master', 'MasterController')->middleware(CheckAssignee::class);

Route::post('/master/editor_upload', 'MasterController@editor_upload')->name('ckeditor.upload');
Route::post('/master/upload_files', 'MasterController@upload_files')->name('master.upload.files');
Route::post('/master/master_bulk_delete', 'MasterController@bulk_delete')->name('master.bulk.delete');

//middleware
Route::post('/todo_comment/{id}', 'MasterController@make_todo_comment')->name('add.todo.comment')->middleware(CheckAssignee::class);

//middleware
Route::put('/todo/{id}', 'MasterController@change_todo_status')->name('change.todo_status')->middleware(CheckAssignee::class);

Route::get('/my_todo_list', 'MasterController@user_todo_list')->name('todo_list');

//middleware
Route::get('/my_todo/{id}', 'MasterController@user_todo')->name('mytodo')->middleware(CheckAssignee::class);

//middleware
Route::delete('/todo_comment/{id}', 'MasterController@delete_todo_comment')->name('delete_todo_comment')->middleware(CheckAssignee::class);

//middleware
Route::put('/todo_comment/{id}', 'MasterController@update_todo_comment')->name('update_todo_comment')->middleware(CheckAssignee::class);

//middleware
Route::post('/incident_comment/{id}', 'MasterController@make_incident_comment')->name('add.incident.comment')->middleware(CheckAssignee::class);

//middleware
Route::put('/incident/{id}', 'MasterController@change_incident_status')->name('change.incident_status')->middleware(CheckAssignee::class);

Route::get('/my_incident_list', 'MasterController@user_incident_list')->name('incident_list');

//middleware
Route::get('/my_incident/{id}', 'MasterController@user_incident')->name('myincident')->middleware(CheckAssignee::class);

//middleware
Route::delete('/incident_comment/{id}', 'MasterController@delete_incident_comment')->name('delete_incident_comment')->middleware(CheckAssignee::class);

//middleware
Route::put('/incident_comment/{id}', 'MasterController@update_incident_comment')->name('update_incident_comment')->middleware(CheckAssignee::class);

Route::get('/user_attendence', 'AttendenceController@index')->name('attendence');
Route::get('/user_attendence/create', 'AttendenceController@create')->name('attendence.create');
Route::post('/user_attendence', 'AttendenceController@store')->name('attendence.store');
Route::get('/user_attendence/edit/{id}', 'AttendenceController@edit')->name('attendence.edit');
Route::put('/user_attendence/{id}', 'AttendenceController@update')->name('attendence.update');

//middleware
Route::get('/attendence_logs/{id}', 'AttendenceController@get_single_attendence')->name('attendence_logs')->middleware(CheckAssignee::class);

Route::get('/child_master/{id}', 'MasterController@get_masterchilds')->name('child_master');
//middleware
Route::get('/evaluation/{id}', 'MasterController@show_evaluation')->name('evaluation')->middleware(CheckAssignee::class);

Route::get('/my_evaluation', 'MasterController@user_evaluation')->name('user_evaluation');
//middleware
Route::post('/evaluation/{id}', 'MasterController@update_evaluation_review')->name('evaluation_review')->middleware(CheckAssignee::class);

Route::post('/master/upload_drive_files', 'MasterController@upload_drive_files')->name('upload_drive_files');
Route::post('/master/delete_drive_file', 'MasterController@delete_drive_file')->name('delete_drive_file');
Route::post('/master/get_drive_files/{id}', 'MasterController@get_drive_files')->name('get_drive_files');

Route::get('/upload_excel', 'MasterController@upload_excel_index')->name('upload.excel.index');
Route::post('/upload_excel', 'MasterController@upload_excel')->name('upload.excel');

Route::get('/send_email/{id}', 'MasterController@send_email')->name('send.email');
Route::post('/send_email/{id}', 'MasterController@post_email')->name('post.email');

Route::get('/send_sms/{id}', 'MasterController@send_sms')->name('send.sms');
Route::post('/send_sms/{id}', 'MasterController@post_sms')->name('post.sms');

Route::get('/settings', 'OptionController@index')->name('option.index');
Route::post('/setting/update', 'OptionController@update')->name('option.update');

Route::get('markasread', function() {
	\Auth::user()->notifications->markAsRead();
	return redirect()->back();
})->name('markAsRead');