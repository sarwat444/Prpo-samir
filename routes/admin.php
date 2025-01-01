




<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ChatController ;

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

CONST PUBLIC_PATH = "" ;
Route::post('/login/store', 'LoginController@Login')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function () {
    Route::get('/custom_login/{user_name?}/{user_pass?}', 'LoginController@getLogin') ;
    Route::post('/login/store', 'LoginController@Login')->name('admin.login');
    Route::get('register', 'LoginController@getRegister')->name('get.admin.register');

});

Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {

    Route::get('/{type?}', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/user/guest', 'DashboardController@guest_index')->name('admin.guest_dashboard');
    Route::post('/change_user_status' ,'DashboardController@change_user_status')->name('admin.change_user_status') ;
    // Route::get('/completed','DashboardController@Completed')->name('admin.dashboard.completed');
    //Route::get('/deleted','DashboardController@Deleted')->name('admin.dashboard.deleted');
    Route::post('/filter/by/category', 'DashboardController@filterByCategory')->name('admin.filter_by_category');
    Route::get('user/logout', 'LoginController@logout')->name('admin.logout');
    Route::post('/users/update/login/status', 'LoginController@UpdateLoginStatus')->name('admin.update_user_login_status');
    Route::post('/users/change/login/status', 'LoginController@ChangeLoginStatus')->name('admin.change_user_login_status');
    Route::get('/all/logs', 'DashboardController@getAllLogs')->name('admin.get.all_logs');
    Route::post('/cat/tags', 'DashboardController@getCatTags')->name('admin.get.cat_tags');
    Route::get('users/all', 'DashboardController@AllUsers')->name('admin.users.all')->middleware('CheckAdmin');
    Route::get('users/piriority', 'DashboardController@getUsersPiriority')->name('admin.users.piriority')->middleware('CheckAdmin');
    Route::post('users/priority/update', 'DashboardController@updateUserPriority')->name('update.users.priority');
    Route::get('accounts/all', 'DashboardController@AllAcounts')->name('admin.accounts')->middleware('CheckAdmin');;
    //crm index page


    Route::get('/crm/index', 'DashboardController@home')->name('crm.index');

    Route::get('/crm/settings', 'DashboardController@settings')->name('admin.settings');
    Route::post('/crm/deleteModule', 'DashboardController@deleteModule')->name('admin.deleteModule');


    Route::group(['prefix' => "crm"], function () {
        Route::get('/crm', 'CategoryController@crm')->name('admin.crm')->middleware('CheckAdmin');
    });

    ######################## Chat #####################################
    Route::group(['prefix' => 'chat', 'as' => 'admin.chat.', 'namespace' => 'chat'], function () {

        Route::get('chat_rooms', [ChatController::class, 'chatRooms'])->name('chat_rooms');
        Route::post('room/chat', [ChatController::class, 'roomMessages'])->name('room_messages');
        Route::post('room/show_room', [ChatController::class, 'show_room'])->name('show_room');
        Route::post('message', [ChatController::class, 'message'])->name('send_message');
        Route::post('craete_room', [ChatController::class, 'craete_room'])->name('craete_room');
        Route::post('check/chat/open', [ChatController::class, 'checkChatOpen'])->name('check_chat_open');
        Route::post('chat/delete', [ChatController::class, 'deleteForMe'])->name('deleteForMe');
        Route::post('chat/delete_everyone', [ChatController::class, 'deleteForEveryone'])->name('deleteForEveryone');
        Route::post('chat_room/block', [ChatController::class, 'blockChatRoom'])->name('block_chat_room');
        Route::post('chat_room/delete', [ChatController::class, 'deletechatRoom'])->name('delete_chat');
        Route::post('addGroup', [ChatController::class, 'addGroup'])->name('addGroup');
    });

    ######################## Begin Categories Routes #####################################

    Route::group(['prefix' => "categories"], function () {

        Route::get('/all/{bell?}', 'CategoryController@index')->name('admin.categories')->middleware('CheckAdmin');
        Route::get('/list', 'CategoryController@allCategories')->name('admin.categories.list')->middleware('CheckAdmin');
        Route::get('/create', 'CategoryController@create')->name('admin.categories.create')->middleware('CheckAdmin');
        Route::post('/store', 'CategoryController@store')->name('admin.categories.store')->middleware('CheckAdmin');
        Route::post('/edit', 'CategoryController@edit')->name('admin.categories.edit')->middleware('CheckAdmin');
        Route::post('/update/{ids}', 'CategoryController@update')->name('admin.categories.update')->middleware('CheckAdmin');
        Route::post('/delete/', 'CategoryController@delete')->name('admin.categories.delete')->middleware('CheckAdmin');

        Route::post('/showtaskcount/', 'CategoryController@showtaskcount')->name('admin.categories.showtaskcount');
        Route::post('/deletewithtasks/', 'CategoryController@deletewithtasks')->name('admin.categories.deletewithtasks');
        Route::post('/deletenotasks/', 'CategoryController@deletenotasks')->name('admin.categories.deletenotasks');

        Route::post('/ajax', 'CategoryController@copySubTaskAjax')->name('categories.ajax');
        Route::post('/cut/ajax', 'CategoryController@cutSubTaskAjax')->name('categories.ajax.cut');
        Route::post('/post/ajax', 'CategoryController@postSubTaskAjax')->name('categories.ajax.post');
        Route::post('/tag/store', 'CategoryController@addTag')->name('admin.tag.store');
        Route::get('/{cat_id}/tasks/{status}/{type?}', 'CategoryController@allTasks')->name('admin.cat.tasks');
        Route::get('tag/{cat_id}/{tag_id}/tasks/{status}', 'CategoryController@allCatTagTasks')->name('admin.cat.tag.tasks');
        Route::post('/{id}/tasks/admin/tasks/save_perority', 'TasksController@sorting');
        Route::post('/tag/{id}/{tag_id}/tasks/admin/tasks/save_perority', 'TasksController@sorting');
        Route::post('/{id}/tasks/admin/subtasks/save_perority', 'SubTasksController@sorting');
        Route::post('/tag/{id}/{tag_id}/tasks/admin/subtasks/save_perority', 'SubTasksController@sorting');
        Route::post('/list', 'CategoryController@updatePriority')->name('categories.update.priority');
        Route::post('/list/tags/modal', 'CategoryController@listTagModal')->name('categories.list.tags');
        Route::post('/updates/modal','CategoryController@category_update_modal')->name('category.update.modal');
        Route::post('/update/modal/tags', 'CategoryController@updateCategoryTagsModal')->name('tags.update.modal');
        Route::post('/edit/modal','CategoryController@edit_category_modal')->name('category.edit.modal');
        Route::post('/categories/tags','CategoryController@getCategoryTag')->name('admin.tags.getCategoryTag');
    });

    Route::group(['prefix' => "tags"], function () {
        Route::get('/all', 'tagsController@index')->name('admin.tags')->middleware('CheckAdmin');;
        Route::get('/create', 'tagsController@create')->name('admin.tags.create')->middleware('CheckAdmin');;
        Route::post('/store', 'tagsController@store')->name('admin.tags.store')->middleware('CheckAdmin');;
        Route::post('/edit', 'tagsController@edit')->name('admin.tags.edit')->middleware('CheckAdmin');

        Route::post('/update/modal', 'tagsController@updateTagModal')->name('tags.update');
        Route::post('/update/{ids}', 'tagsController@update')->name('admin.tags.update');
        Route::post('/delete/', 'tagsController@delete')->name('admin.tags.delete');
        Route::post('/edit/modal', 'tagsController@editTagModal')->name('tags.edit');

    });
    ######################## End Categories Routes #####################################

    ######################## Begin Tasks Routes #####################################
    Route::group(['prefix' => "tasks"], function () {


        // Route::get('/images/datatables/{type}', 'ImagesController@datatables')->name('admin-images-datatables'); //JSON REQUEST
        Route::get('/all', 'TasksController@index')->name('admin.tasks');
        Route::get('/pending_posts', 'TasksController@pending_posts')->name('admin.tasks.pending_posts');
        Route::post('/filter_myposts' ,'TasksController@fillterMyposts' )->name('admin.filter.myposts') ;
        Route::get('/create', 'TasksController@create')->name('admin.tasks.create');
        Route::post('/store', 'TasksController@store')->name('admin.tasks.store');
        Route::post('/edit', 'TasksController@edit')->name('admin.tasks.edit');
        Route::post('/update/{id}', 'TasksController@update')->name('admin.tasks.update');
        Route::post('/delete/', 'TasksController@delete')->name('admin.tasks.delete');
        Route::get('/my_posts', 'TasksController@my_posts')->name('admin.tasks.my_posts');
        Route::post('/accept_task', 'TasksController@accept_task')->name('admin.tasks.accept_task');
        Route::post('/mark/complete', 'TasksController@markComplete')->name('admin.tasks.mark_complete');
        Route::post('/undelete/', 'TasksController@undelete')->name('admin.tasks.undelete');
        Route::post('/mark/uncomplete', 'TasksController@unmarkComplete')->name('admin.tasks.mark_uncomplete');
        Route::post('iamge/removebackgroundImage', 'TasksController@removebackgroundImage')->name('admin.tasks.removebackgroundImage');



        Route::post('/update/status/{id}', 'TasksController@updateStatus')->name('admin.tasks.update_status');

        Route::post('/get/data', 'TasksController@showTaskData')->name('admin.get.task_data');
        Route::PUT('/update/idea/{id}', 'TasksController@updateIdeaTask')->name('admin.ides.update');
        Route::post('/get/idea/data', 'TasksController@showIdeaTaskData')->name('admin.get_idea_task_data');
        Route::post('/get/viewTaskData', 'TasksController@viewTaskData')->name('admin.viewTaskData');

        Route::post('/create/view', 'TasksController@getCreateView')->name('admin.get.create_view');
        Route::post('/update/task/field', 'TasksController@updateTaskfield')->name('admin.tasks.update_field');
        Route::get('/mytasks', 'TasksController@usertasks')->name('admin.usertasks');   // User Tasks
        Route::post('/filter/subtasks', 'TasksController@filterUserSubtasks')->name('admin.filter.usertasks');   // User Tasks

        Route::post('/filter/historysubtasks2', 'TasksController@filterUserhistorySubtasks')->name('admin.filter.userhistorytasks');   // User history Tasks time
        Route::post('/filter/historysubtasks', 'CommentsController@filtercomments')->name('admin.filter.filtercomments');   // User history Tasks time
        Route::post('/filter/filterReplays', 'CommentsController@filterReplays')->name('admin.filter.filterReplays');   // User history Tasks time
        Route::post('/filter/filltercommentsandreplays', 'CommentsController@filltercommentsandreplays')->name('admin.filter.filltercommentsandreplays');

        Route::post('/filtertest', 'CommentsController@filtertests')->name('admin.filter.filltertest');

        Route::post('/filter/deletecomment', 'CommentsController@deletecomment')->name('admin.comments.deletecomment');   // User history Tasks time
        Route::post('/filter/donecomment', 'CommentsController@donecomment')->name('admin.comments.donecomment');
        Route::post('savetags', 'CommentsController@savetags')->name('admin.comments.savetags');
        Route::post('/log/update/read', 'TasksController@updateLogRead')->name('admin.update_log_read');   // User Tasks
        Route::post('/replay_update', 'TasksController@updatereplay')->name('admin.update_replay_read');
        Route::post('/comment_read', 'TasksController@commentread')->name('admin.update_comment_read');
        Route::post('/replay_updatenotify', 'TasksController@updatereplaynotify')->name('admin.update_replay_readnotify');
        Route::post('/comment_updatenotify', 'TasksController@updatecommentnotify')->name('admin.update_comment_readnotify');




        Route::post('/save_perority', 'TasksController@sorting');
        Route::get('/guest/subtasks', 'TasksController@guestsubtasks')->name('admin.guestsubtasks');
        Route::post('/filter/guest/subtasks', 'TasksController@filterGuestSubtasks')->name('admin.filter.guesttasks');   // Guest Sub Tasks
        Route::post('/get/all/subtasks', 'TasksController@getAllSubtasks')->name('admin.task.get.subtasks');
        Route::post('/copy/tasks', 'TasksController@copytask')->name('admin.tasks.copy');


        /* Upload task  image */
        Route::post('/upload_post_image', 'TasksController@upload_post_image')->name('tasks.upload_post_image');


    });

    ######################## End tasks Routes #####################################

    ######################## Begin SubTasks Routes #####################################
    Route::group(['prefix' => "subtasks"], function () {
        // Route::get('/images/datatables/{type}', 'ImagesController@datatables')->name('admin-images-datatables'); //JSON REQUEST
        Route::get('/all', 'SubTasksController@index')->name('admin.subtasks');
        Route::get('/create', 'SubTasksController@create')->name('admin.subtasks.create');
        Route::post('/store', 'SubTasksController@store')->name('admin.subtasks.store');
        Route::post('/subtasks/store_image', 'SubTasksController@storeImage')->name('admin.subtasks.store_image');
        Route::post('/edit', 'SubTasksController@edit')->name('admin.subtasks.edit');
        Route::post('/update/{ids}', 'SubTasksController@update')->name('admin.subtasks.update');
        Route::post('/delete/', 'SubTasksController@delete')->name('admin.subtasks.delete');
        Route::post('/change/status/', 'SubTasksController@updateStatus')->name('admin.subtasks.update_status');
        Route::post('/change/subtaskstatus/', 'SubTasksController@updatesubStatus')->name('admin.subtasks.updatesubtask_status');
        Route::post('/get/responsiple', 'SubTasksController@taskresponsiple')->name('admin.get.subtaskresponsiple');
        Route::post('/change/fieldd', 'SubTasksController@updateFieldd')->name('admin.subtasks.updatefielddd');
        Route::post('/store/comment', 'SubTasksController@storeComment')->name('admin.subtasks.store_comment');
        Route::get('/view/comment', 'CommentsController@index')->name('admin.subtasks.viewcomments');
        Route::post('/save_perority', 'SubTasksController@sorting');
        Route::post('/store_time', 'SubTasksController@storeTime')->name('admin.subtasks.store_time');
        Route::post('/store_timer', 'SubTasksController@store_timer')->name('admin.subtasks.store_timer');
        Route::post('/get_timer', 'SubTasksController@get_timer')->name('admin.subtasks.get_timer');
        Route::post('/get_timers', 'SubTasksController@get_timers')->name('admin.subtasks.get_timers');
        Route::post('/starttime', 'SubTasksController@starttime')->name('admin.subtasks.starttime');
        Route::post('/clone/{id}', 'SubTasksController@copy_subtask')->     name('subtask.clone');
        Route::post('/cut/{id}', 'SubTasksController@cut_subtask')->name('subtask.cut');

        Route::get('/subtasks_history', 'SubTasksController@task_history')->name('admin.subtasks.task_history');

        Route::get('/assigned_tasks', 'SubTasksController@assigned_tasks')->name('admin.subtasks.assigned_tasks');

        Route::post('/historydescription', 'SubTasksController@historydescription')->name('admin.subtasks.historydescription');

        Route::post('/changetester', 'SubTasksController@changetester')->name('admin.subtasks.test');
        Route::post('/tested', 'SubTasksController@tested')->name('admin.subtasks.tested');
        Route::get('/tests', 'SubTasksController@tests')->name('admin.subtasks.tests');
        Route::post('/filter-assign_tasks', 'SubTasksController@filter_assigned')->name('admin.subtasks.filter_assigned');


        Route::post('/storereplay', 'SubTasksController@storereplay')->name('admin.subtasks.store_replay');

        Route::post('/filtertestbtn', 'SubTasksController@filtertestbtn')->name('admin.subtasks.filtertestbtn');
        Route::post('/filtercreatedbtn', 'SubTasksController@filtercreatedbtn')->name('admin.subtasks.filtercreatedbtn');
        Route::post('/orderadminsubtasks', 'TasksController@orderadminsubtasks')->name('admin.subtasks.order');


    });

    ######################## End Subtasks Routes #####################################

    ######################## Begin Users Routes #####################################
    Route::group(['prefix' => "users"], function () {

        Route::post('/edit', 'LoginController@editUser')->name('admin.users.edit');
        Route::post('/edit-user', 'LoginController@editUserModal')->name('users.edit');
        Route::post('/update-user', 'LoginController@updateUserModal')->name('users.update');

        Route::post('/update/{ids}', 'LoginController@updateUser')->name('admin.users.update');
        Route::post('/delete/', 'LoginController@deleteUser')->name('admin.users.delete');

    });

######################## End Users Routes #####################################


    ######################## Begin Chats Routes #####################################
    Route::group(['prefix' => "chats"], function () {
        Route::get('/all', 'MessageController@index')->name('all_chats');
        Route::get('/message/{id}', 'MessageController@getMessage')->name('message');
        Route::post('message', 'MessageController@sendMessage')->name('message2');
    });

    ######################## End Chats Routes #####################################

    ######################## Begin Comment Routes #####################################
    Route::group(['prefix' => "comments"], function () {
        Route::post('/update', 'SubTasksController@updateComment')->name('admin.comments.update');
        Route::post('/delete', 'SubTasksController@deleteComment')->name('admin.comments.delete');
        Route::post('/delete_replay', 'SubTasksController@deletereplay')->name('admin.comments.delete_replay');
        Route::post('/edit_replay', 'SubTasksController@updatereplay')->name('admin.comments.editreplay');
        Route::post('/show_read_comments', 'SubTasksController@show_comments')->name('admin.comments.show_read_comments');
        Route::post('/viewreplays', 'SubTasksController@viewreplays')->name('admin.comments.viewreplays');
        Route::post('/getTaskComments', 'SubTasksController@GetTaskComments')->name('admin.comments.getTaskComments');
    });

    ######################## End Comment Routes #####################################


    Route::group(['prefix' => "sections"], function () {
        // Route::get('/images/datatables/{type}', 'ImagesController@datatables')->name('admin-images-datatables'); //JSON REQUEST
        Route::get('/', 'SectionController@index')->name('admin.sections');
        Route::get('/create', 'SectionController@create')->name('admin.sections.create');
        Route::post('/store', 'SectionController@store')->name('admin.sections.store');
        Route::post('/edit', 'SectionController@edit')->name('admin.sections.edit');
        Route::post('/update/{ids}', 'SectionController@update')->name('admin.sections.update');
        Route::post('/delete/', 'SectionController@delete')->name('admin.sections.delete');
    });

    ######################## End Images Routes #####################################
    ######################## Start ides Routes #####################################
    Route::group(['prefix' => "ides"], function () {
        Route::post('/store', 'SubTasksController@store_ideas')->name('admin.ides.store');
    });
    ######################## End ides Routes #####################################
    ######################## Start User Routes #####################################
    Route::group(['prefix' => "user"], function () {
        // Route::get('/images/datatables/{type}', 'ImagesController@datatables')->name('admin-images-datatables'); //JSON REQUEST
        Route::get('{user_id}/tasks/{status}', 'LoginController@userTasks')->name('admin.user.tasks');

    });

    ######################## End User Routes #####################################
    ######################## Begin Packages Routes #####################################
    Route::group(['prefix' => "packages"], function () {
        Route::get('/all', 'PackageController@index')->name('admin.packages')->middleware('CheckAdmin');;
        Route::get('/create', 'PackageController@create')->name('admin.packages.create')->middleware('CheckAdmin');;
        Route::post('/store', 'PackageController@store')->name('admin.packages.store');
        Route::post('/edit', 'PackageController@edit')->name('admin.packages.edit');
        Route::post('/add/account', 'PackageController@AddAccount')->name('admin.packages.add_account');
        Route::post('/update/{ids}', 'PackageController@update')->name('admin.packages.update');
        Route::post('/delete/', 'PackageController@delete')->name('admin.packages.delete');

    });
    ######################## End Packages Routes #####################################
    ######################## Begin Account Routes #####################################

    Route::group(['prefix' => "accounts"], function () {
        Route::get('/create', 'LoginController@createAccount')->name('admin.accounts.create')->middleware('CheckAdmin');
        Route::post('/edit', 'LoginController@editAccount')->name('admin.accounts.edit');
        Route::post('/update/{ids}', 'LoginController@updateAccount')->name('admin.accounts.update');
        Route::post('/delete/', 'LoginController@deleteAccount')->name('admin.accounts.delete');

    });


    ######################## End Users Routes #####################################

    Route::post('/user/store', 'LoginController@storeRegister')->name('admin.register');
    Route::post('/guest/store', 'LoginController@storeGuest')->name('admin.guest.store');
    Route::post('/account/store', 'LoginController@storeAccount')->name('admin.account.store');
    Route::post('/invite/store', 'LoginController@storeInvite')->name('admin.invite.store');
    Route::get('/invite/accept/{invite_id}', 'LoginController@AcceptInvite')->name('admin.invite.accept');
    Route::post('/profile/update', 'LoginController@profileupdate')->name('admin.profile.update');

    Route::get('/cache/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize');
    });

    Route::get('lang/home', 'LangController@index');

    Route::get('lang/change', 'LangController@change')->name('changeLang');

});

Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function () {

    Route::get('admin/login/{user_name?}/{user_pass?}', 'LoginController@getLogin')->name('get.admin.login');
    Route::post('/login/store', 'LoginController@Login')->name('admin.login');
    Route::get('register', 'LoginController@getRegister')->name('get.admin.register');

});




