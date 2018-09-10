<?php

/*
|--------------------------------------------------------------------------
| Package Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the TaskSchedulerServiceProvider.
|
*/

Route::group(['namespace' => 'Smeechos\TaskScheduler\Http\Controllers'], function () {
    Route::get('task-scheduler/crons', 'CronController@index')->name('crons');
    Route::get('task-scheduler/crons/edit/{id}', 'CronController@edit');
    Route::get('task-scheduler/crons/delete/{id}', 'CronController@show');
    Route::post('task-scheduler/crons/edit/{id}', 'CronController@update');
    Route::post('task-scheduler/crons/add', 'CronController@store' );
    Route::post('task-scheduler/crons/delete/{id}', 'CronController@destroy');

    Route::get('task-scheduler/tasks', 'TaskController@index')->name('tasks');
    Route::get('task-scheduler/tasks/edit/{id}', 'TaskController@edit');
    Route::get('task-scheduler/tasks/delete/{id}', 'TaskController@show');
    Route::post('task-scheduler/tasks/edit/{id}', 'TaskController@update');
    Route::post('task-scheduler/tasks/add', 'TaskController@store' );
    Route::post('task-scheduler/tasks/delete/{id}', 'TaskController@destroy');

    Route::get('task-scheduler/settings', 'SettingsController@index')->name('settings');
    Route::post('task-scheduler/settings', 'SettingsController@store');
});




//Route::group(['middleware' => ['web']], function () {
//    Route::get('task-scheduler/tasks', function() {
//        return view('task-scheduler::tasks.index');
//    })->name('tasks');
//
//    Route::get('task-scheduler/crons', function() {
//        return view('task-scheduler::crons.index');
//    })->name('crons');
//
//    Route::get('/task-scheduler/cron/edit/{id}', function() {
//        return view('task-scheduler::crons.edit');
//    })->name('crons');
//});