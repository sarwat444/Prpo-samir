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
Route::group(['namespace' =>'Admin','middleware' => 'auth:admin'],function (){

    Route::get('/{type?}','DashboardController@index')->name('admin.dashboard');
   // Route::get('/completed','DashboardController@Completed')->name('admin.dashboard.completed');
    //Route::get('/deleted','DashboardController@Deleted')->name('admin.dashboard.deleted');
    Route::post('/filter/by/category','DashboardController@filterByCategory')->name('admin.filter_by_category');
    Route::get('/logout','LoginController@logout')->name('admin.logout');


    ######################## Begin Categories Routes #####################################
    Route::group(['prefix' => "categories"],function (){
        Route::get('/all','CategoryController@index')->name('admin.categories');
        Route::get('/create','CategoryController@create')->name('admin.categories.create');
        Route::post('/store','CategoryController@store')->name('admin.categories.store');
        Route::post('/edit','CategoryController@edit')->name('admin.categories.edit');
        Route::post('/update/{ids}','CategoryController@update')->name('admin.categories.update');
        Route::post('/delete/','CategoryController@delete')->name('admin.categories.delete');
    });

    ######################## End Categories Routes #####################################

    ######################## Begin Tasks Routes #####################################
   Route::group(['prefix' => "tasks"],function (){
        // Route::get('/images/datatables/{type}', 'ImagesController@datatables')->name('admin-images-datatables'); //JSON REQUEST
        Route::get('/all','TasksController@index')->name('admin.tasks');
        Route::get('/create','TasksController@create')->name('admin.tasks.create');
        Route::post('/store','TasksController@store')->name('admin.tasks.store');
        Route::post('/edit','TasksController@edit')->name('admin.tasks.edit');
        Route::post('/update/{id}','TasksController@update')->name('admin.tasks.update');
        Route::post('/delete/','TasksController@delete')->name('admin.tasks.delete');
        Route::post('/mark/complete','TasksController@markComplete')->name('admin.tasks.mark_complete');
        Route::post('/undelete/','TasksController@undelete')->name('admin.tasks.undelete');
        Route::post('/mark/uncomplete','TasksController@unmarkComplete')->name('admin.tasks.mark_uncomplete');
        
        Route::post('/update/status/{id}','TasksController@updateStatus')->name('admin.tasks.update_status');
        Route::post('/get/data','TasksController@showTaskData')->name('admin.get.task_data');
        Route::post('/create/view','TasksController@getCreateView')->name('admin.get.create_view');

        Route::post('/update/task/field','TasksController@updateTaskfield')->name('admin.tasks.update_field');
        
        Route::get('/mytasks','TasksController@usertasks')->name('admin.usertasks');   // User Tasks 
        
        Route::get('/mytasks','TasksController@usertasks')->name('admin.usertasks');   // User Tasks 
        
         Route::post('/filter/subtasks','TasksController@filterUserSubtasks')->name('admin.filter.usertasks');   // User Tasks 

    });

    ######################## End tasks Routes #####################################

    ######################## Begin SubTasks Routes #####################################
   Route::group(['prefix' => "subtasks"],function (){
        // Route::get('/images/datatables/{type}', 'ImagesController@datatables')->name('admin-images-datatables'); //JSON REQUEST
        Route::get('/all','SubTasksController@index')->name('admin.subtasks');
        Route::get('/create','SubTasksController@create')->name('admin.subtasks.create');
        Route::post('/store','SubTasksController@store')->name('admin.subtasks.store');
        Route::post('/edit','SubTasksController@edit')->name('admin.subtasks.edit');
        Route::post('/update/{ids}','SubTasksController@update')->name('admin.subtasks.update');
        Route::post('/delete/','SubTasksController@delete')->name('admin.subtasks.delete');
        Route::post('/change/status/','SubTasksController@updateStatus')->name('admin.subtasks.update_status');
        Route::post('/get/responsiple','SubTasksController@taskresponsiple')->name('admin.get.subtaskresponsiple');
        Route::post('/change/fieldd','SubTasksController@updateFieldd')->name('admin.subtasks.updatefielddd');
        Route::post('/store/comment','SubTasksController@storeComment')->name('admin.subtasks.store_comment');

    });

    ######################## End Subtasks Routes #####################################




        Route::group(['prefix' => "sections"],function (){
            // Route::get('/images/datatables/{type}', 'ImagesController@datatables')->name('admin-images-datatables'); //JSON REQUEST
            Route::get('/','SectionController@index')->name('admin.sections');

            Route::get('/create','SectionController@create')->name('admin.sections.create');
            Route::post('/store','SectionController@store')->name('admin.sections.store');
            Route::post('/edit','SectionController@edit')->name('admin.sections.edit');
            Route::post('/update/{ids}','SectionController@update')->name('admin.sections.update');
            Route::post('/delete/','SectionController@delete')->name('admin.sections.delete');


        });

        ######################## End Images Routes #####################################



        Route::post('/user/store','LoginController@storeRegister')->name('admin.register');
       Route::post('/profile/update', 'LoginController@profileupdate')->name('admin.profile.update');


  });

Route::group(['namespace' =>'Admin','middleware' => 'guest:admin'],function (){

     //dd('sdasfdafdsfdsvdsdsffdsfdsfdsfdsfdsfdfdfdsfdsfdsfdsf');
    Route::get('login','LoginController@getLogin')->name('get.admin.login');
    Route::post('/login/store','LoginController@Login')->name('admin.login');
    Route::get('register','LoginController@getRegister')->name('get.admin.register');

});
