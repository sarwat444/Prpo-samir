<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Chat_Api\ChatController;
use App\Http\Controllers\Chat_Api\PusherAuthController;
use App\Http\Controllers\Chat_Api\NewsController;
use App\Http\Controllers\Chat_Api\SupportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['api'], 'namespace' => 'Api'], function () {


    Route::group(['prefix' => 'fcm'], function () {
        Route::post('/add', 'FcmController@store')->middleware('auth:api');
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/forget-password', 'AuthController@forget_password')->middleware('throttle:3,5');
        Route::post('/login', 'AuthController@login');
        Route::get('/forget-password', 'AuthController@get_forget_password')->name('get-forget-password');
        Route::post('/reset-password', 'AuthController@reset_password')->name('reset-password');
        Route::post('change-password', 'AuthController@Change_Password')->middleware('auth:api');
        Route::get('/register-settings', 'AuthController@ResgisterSettings')->name('get-register-settings');
        Route::post('/user/store'  ,     'AuthController@storeRegister')->name('user.store.register');
        Route::post('/user/delete'  ,     'AuthController@deleteUser')->name('user.delete');
    });

        Route::group(['prefix' => 'tasks', 'middleware' => 'auth:api'], function () {
                 Route::get('all' ,'TaskController@allTasks') ;
                Route::get('categoryTasks/{type?}/{category_id?}', 'DashboardController@index');
                Route::post('/update/task/field', 'TaskController@updateTaskfield');
                Route::post('/orderadminsubtasks', 'TaskController@orderadminsubtasks');
                Route::get('all/{category_id?}/{type?}', 'TaskController@index');
                Route::delete('/{id}', 'TaskController@destroy')->middleware('isAdmin');
                Route::post('/add', 'TaskController@addTask');
                Route::get('/details/{id}', 'TaskController@getTask');
                Route::get('/{id}/comments', 'TaskController@taskComments');
                Route::post('/{id}/complete', 'TaskController@complete');
                Route::post('/undelete/', 'TaskController@undelete');
                Route::post('/mark/uncomplete', 'TaskController@unmarkComplete');
                Route::post('/{id}/attachment', 'TaskController@attachment');
                Route::post('/{id}/comment', 'TaskController@addComment');
                Route::post('/{id}/assignUser', 'TaskController@assignUser');
                Route::patch('/{id}/updateResponsible', 'TaskController@updateResponsible');
                Route::put('/{id}/update', 'TaskController@update');
                Route::post('/{id}/copy', 'TaskController@copyTask');

    });

    Route::group(['prefix' => 'categories', 'middleware' => 'auth:api'], function () {
        Route::get('/{id?}', 'CategoryController@index');
        Route::post('/', 'CategoryController@store')->middleware('isAdmin');
        Route::delete('/{id}', 'CategoryController@toggleDelete');
        Route::get('/{id}/tasks', 'CategoryController@tasks');
        Route::get('/{id}/tasks/{tag_id}/tag', 'CategoryController@tagTasks');
        Route::post('/tag/store', 'CategoryController@addTag');
    });

    Route::group(['prefix' => 'timetracking', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'TimetrackingController@index');
        Route::post('/filter/historysubtasks', 'TaskController@filterUserhistorySubtasks');
        Route::post('/historydescription', 'SubtaskController@historydescription');
        Route::post('/TimeTrackingChart', 'SubtaskController@TimeTrackingChart');
    });

    Route::group(['prefix' => 'assigned_tasks', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'SubtaskController@assigned_tasks');
        Route::post('/changetester', 'SubtaskController@changetester');
        Route::post('/tested', 'SubtaskController@tested');
        Route::get('/tests', 'SubtaskController@tests');
        Route::post('/filter-mytest', 'SubtaskController@filter_mytest');
        Route::post('/filter-assign_tasks', 'SubtaskController@filter_assigned');
    });


    Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'UserController@index');
        Route::get('/{id}', 'UserController@find')->middleware('isAdmin');
        Route::put('/{id}', 'UserController@update')->middleware('isAdmin');
        Route::delete('/{id}', 'UserController@destroy')->middleware('isAdmin');
        Route::get('/{id}/tasks', 'UserController@userPostIt');
        Route::get('/tasks/all', 'UserController@postIt');
        Route::post('/profile/update', 'LoginController@profileupdate');   //update profile
        Route::post('/store'  , 'UserController@store')->name('user.store');
        Route::post('/storeGuest'  , 'UserController@storeGuest')->name('user.storeGuest');
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/get', 'UserController@profile');
        });
        Route::post('/invite'  , 'UserController@invite')->name('user.invite');
    });


    Route::group(['prefix' => 'subtasks', 'middleware' => 'auth:api'], function () {
        Route::post('/categorysubtasks', 'SubtaskController@categorysubtasks');
        Route::post('/me', 'SubtaskController@mySubtasks');
        Route::post('/storereplay', 'SubtaskController@storereplay');
        Route::post('/viewreplays', 'SubtaskController@viewreplays') ;
        Route::post('/delete_replay', 'SubtaskController@deletereplay');
        Route::post('/all', 'SubtaskController@index');
        Route::post('/store', 'SubtaskController@store');

        Route::post('/storecommentImag', 'SubtaskController@storecommentImage');
        Route::put('/update/{id}', 'SubtaskController@update');

        Route::get('/{id}', 'SubtaskController@find');
        Route::get('/{id}/time-tracking', 'SubtaskController@timeTracking');
        Route::post('/{id}/start', 'SubtaskController@start');
        Route::post('/{id}/copy', 'SubtaskController@copy');

        Route::post('/{id}/cut', 'SubtaskController@cut');
        Route::post('/{id}/store_timer', 'SubtaskController@store_timer');
        Route::post('/{id}/assignUser', 'SubtaskController@assignUser');
        Route::post('/{id}/dueDate', 'SubtaskController@updateDueDate');
        Route::delete('/delete/{id}', 'SubtaskController@destroy');
        Route::post('/complete/{id}', 'SubtaskController@toggleCompleted');
        Route::get('/me/running', 'SubtaskController@getRunningTask')->name('getRunningTask');

    });

    Route::group(['prefix' => 'helper'], function () {
        Route::post('/optimize', function () {
            Artisan::call('route:cache');
            Artisan::call('route:clear');
            Artisan::call('config:cache');
            Artisan::call('optimize');
            return response()->json([
                'message' => 'optimized'
            ]);
        });

    });

    Route::group(['prefix' => 'comments', 'middleware' => 'auth:api'], function () {
        Route::post('/update', 'CommentController@updateComment');
        Route::get('/', 'CommentController@index');
        Route::delete('/{id}', 'CommentController@destroy');
        Route::get('/{id}', 'CommentController@find');
        Route::post('/toggleSeen', 'CommentController@seenComment');
        Route::post('/{id}/hide', 'CommentController@hide');
        Route::post('/{id}/reply', 'CommentController@reply');
        Route::get('/me/tagged', 'CommentController@taggedComments');
        Route::post('/replay_update', 'TaskController@updatereplay');
        Route::post('/{id}/subtaskcomments', 'CommentController@subtaskcomments');
        Route::post('/donecomment', 'CommentController@donecomment');


        /*
        Route::post('/filter', 'CommentController@filtercomments');
        */
        Route::post('/filter/filltercomments', 'CommentController@filtercomments');   // User history Tasks time
        Route::post('/filter/comments/replies/', 'CommentController@filltercommentsandreplays');

        Route::group(['prefix' =>'replies'],function (){
            Route::get('/{id}','ReplyController@find');
            Route::patch('/{id}','ReplyController@update');
            Route::delete('/{id}','ReplyController@destroy');
            Route::post('/filter', 'CommentController@filterReplays');
        });
    });

    Route::group(['prefix' => 'notifications', 'middleware' => 'auth:api'], function () {

        Route::get('/', 'LogController@index');

    });


    Route::group(['prefix' => 'users'], function () {
        Route::get('/add/{user_id}/{first_name}/{last_name}/{user_name}/{email}/{password}', 'LoginController@addUser');
        Route::get('/edit/{user_id}/{name_password}', 'LoginController@editUserPass');

    });

    Route::group(['prefix' => 'categorysubtasks', 'middleware' => 'auth:api'], function () {
        Route::post('/categorysubtasks', 'SubtaskController@categorysubtasks');
    });

});



Route::group(['prefix' => 'new_chat'], function () {

    Route::group(['prefix'=>'users'],function (){
        Route::post('login', [\App\Http\Controllers\Chat_Api\AuthController::class , 'login']);
        Route::post('register',[\App\Http\Controllers\Chat_Api\AuthController::class , 'register']);
    });

    Route::get('all/user/unseen/messages',  [ChatController::class , 'get_all_unseen_messages_count']);

    Route::get('/toggle-register', [\App\Http\Controllers\Chat_Api\AuthController::class, 'toggleRegister']);

    Route::group(['middleware' => 'auth:api'], function () {

            Route::get('chat_rooms/{type?}'          , [ChatController::class , 'chatRooms'])->name('chat_rooms');
            Route::get('room/chat/{room_id}/{type}'  , [ChatController::class , 'roomMessages'])->name('chat_rooms');
            Route::get('chat/room/media/{room_id}'   , [ChatController::class , 'getRoomMedia'])->name('room_media');

            Route::post('message'                    , [ChatController::class , 'message'])->name('send_message');
            Route::post('check/chat/open'            , [ChatController::class , 'checkChatOpen'])->name('check_chat_open');
            Route::post('chat/delete', [ChatController::class , 'deleteForMe'])->name('delete_chat');
            Route::post('chat_room/block', [ChatController::class , 'blockChatRoom'])->name('block_chat_room');
            Route::post('chat_room/delete', [ChatController::class , 'deletechatRoom'])->name('delete_chat');
            Route::get('user/unseen/messages',  [ChatController::class , 'getunseenMessages']);
            Route::post('users/update/fcm_token',  [ChatController::class , 'updatefcmToken']);


            Route::group(['prefix'=>'group' ,'as' => 'group.'],function () {
                Route::post('/add', [ChatController::class , 'addGroup'])->name('add');
                Route::post('/edit', [ChatController::class , 'editGroup'])->name('edit');
                Route::delete('/delete/{group_id}', [ChatController::class , 'deleteGroup'])->name('delete');
                Route::post('add/members', [ChatController::class , 'addGroupMember'])->name('add_member');
                Route::get('/info/{group_id}', [ChatController::class , 'groupInfo'])->name('info');
                Route::post('/delete/member', [ChatController::class , 'deleteGroupMember'])->name('delete_member');
            });

            Route::group(['prefix'=>'news' ,'as' => 'news.'],function () {
                Route::get('/', [NewsController::class , 'index'])->name('index');
                Route::get('/{news_id}', [NewsController::class , 'news_info'])->name('news_info');
                Route::post('/operations', [NewsController::class , 'ajax_request'])->name('ajax_request');
            });

            Route::group(['prefix'=>'support' ,'as' => 'support.'],function () {
                Route::get('/menus', [SupportController::class , 'get_sub_menus_of_support'])->name('get_sub_menus_of_support');
            });

            Route::group(['prefix'=>'Chat' ,'as' => 'Chat.'],function () {
                Route::get('/client_chat/{clientId}/unread',  [SupportController::class , 'client_chat'])
                ->name('u_type_permission_path');
            });

            Route::get('/all/members', [ChatController::class , 'getAllMembers'])->name('all_members');

            Route::post('search', [ChatController::class , 'search'])->name('search');
            Route::post('search_chat', [ChatController::class , 'searchChat'])->name('search_chat');

            Route::post('/pusher/auth', [PusherAuthController::class ,'authenticate']);
            Route::post('users/delete',  [\App\Http\Controllers\Chat_Api\AuthController::class , 'delete']);

    });
});
