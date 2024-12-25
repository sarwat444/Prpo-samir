<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\TaskGuest;
use App\Models\TaskTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\Category;
use App\Models\Log;
use App\Models\User;
use App\Models\Replay;
use App\Models\Comment;
use App\Models\TaskTeam;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomResponse;
use App\Helpers\SendNotification;
use App\Events\NewNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class TaskController extends Controller

{


    protected $response;
    protected $notification;

    public function __construct(CustomResponse $response, SendNotification $notification)

    {
        $this->response = $response;
        $this->notification = $notification;
    }

    /*
     * optional params status = completed or deleted
     * no data in body
     * query params => title enables you to search for task
     *  return array of tasks
     * */


    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        if(Paginator::resolveCurrentPage() > 1)
        {
            if( $items->count() > 0 )
            {
                foreach ($items as $item )
                {
                    $new_items[] = $item ;
                }
                $items = $new_items instanceof Collection ? $new_items : Collection::make($new_items);
                return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
            }
        }else {
            $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
            $items = $items instanceof Collection ? $items : Collection::make($items);
            return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        }
    }


    public function index(Request $request,$category_id = null ,$type = null): JsonResponse
    {
        if ($type !== null) {
            $valid_types = ["completed", "deleted"];
            if (!in_array($type, $valid_types)) {
                return response()->json([
                    'message' => 'invalid task type',
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }

        }
        try {

            $user = Auth::user();
            $tasksids = \App\Models\TaskTeam::where('account_id', auth()->user()->account_id)->where('user_id', auth()->user()->id)->pluck('task_id');
            if(!empty($category_id)) {
                //Tasks with category id fillter

                if(auth::user()->role == 1) {
                    $tasks = Task::where('task_category_id', $category_id)->where('task_status', 0)
                                    ->with('added_by' , 'team.user' ,'category' ,'second_category' ,'un_completed_subtasks_count' , 'completed_subtasks_count')
                                    ->paginate(config('constants.PER_PAGE'));

                }else
                {
                    $tasks = Task::where('task_category_id', $category_id)->where('task_status', 0)->where('task_added_by', auth()->user()->id)
                        ->with('added_by' , 'team.user' ,'category' ,'second_category','un_completed_subtasks_count' , 'completed_subtasks_count')
                        ->OrWhere('task_category_id', $category_id)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                        ->Orwhere('task_category_id', $category_id)->whereIn('id', $tasksids)->where('task_status', 0)->paginate(config('constants.PER_PAGE'));
                }
              return response()->json([
                  'message' => 'pending Tasks with Cateogry' ,
                  'tasks' => $tasks,
                  'status' => true
              ], Response::HTTP_OK);


            } else {
                if (auth()->user()->role == 1) {
                    $tasks = Task::where('task_status', 0) ->with('added_by' , 'team.user' ,'category' ,'second_category','un_completed_subtasks_count' , 'completed_subtasks_count')->paginate(config('constants.PER_PAGE'));
                } else {
                    $tasks = Task::WhereIn('id', $tasksids)->where('task_status', 0)->with('added_by' , 'team.user' ,'category' ,'second_category','un_completed_subtasks_count' , 'completed_subtasks_count')->orderBy('task_priority', 'asc')->paginate(config('constants.PER_PAGE'));
                }
                return response()->json([
                    'message' => 'pending Tasks' ,
                    'tasks' => $tasks,
                    'status' => true
                ], Response::HTTP_OK);

            } //end fillter pending





            if ($request->has('title') && !empty($request->input('title'))) {
                $tasks->where('task_title', 'Like', '%' . $request->input('title') . '%');
            }

            $tasks = $tasks->withCount(['completed_subtasks', 'un_completed_subtasks']);
            $tasks = $tasks->paginate(config('constants.PER_PAGE'));
            $categories = Category::where('account_id', $user->account_id)->paginate(config('constants.PER_PAGE'));


            return response()->json([
                'tasks' => $tasks,
                'categories' => $categories,
                'status' => true
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }


    }

    /*
     *  params id = the task id
     * data in body
     * no query params
     *  return updated task
     */
    public function addTask(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'task_title' => 'required|string|max:60',
                'task_desc' => 'required',
                'task_category_id' => 'required',
                'task_responsible' => 'required',
                'task_due_date'    => 'present|nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            DB::beginTransaction();
            $data = new Task();
            $data->task_title = $request->task_title;
            $data->task_desc = $request->task_desc;
            $data->task_category_id = $request->task_category_id;
            $data->task_category_id_two = $request->task_category_id_two;
            $data->task_added_by = Auth::user()->id;
            $data->task_responsible = $request->task_responsible;
            $data->task_due_date = date('Y-m-d', strtotime($request->task_due_date));
            $data->account_id = auth()->user()->account_id;
            $data->save();
            $inserted_id = $data->id;
            $data->task_priority = $inserted_id;
            $data->save();
            if (!empty($request->teams_id)) {
                $interest_array = $request->teams_id;
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {

                    if ($interest_array[$i] == Auth::user()->id || $interest_array[$i] == $request->task_responsible) {
                        continue;
                    } else {
                        $dta = new TaskTeam();
                        $dta->user_id = $interest_array[$i];
                        $dta->task_id = $inserted_id;
                        $dta->account_id = auth()->user()->account_id;
                        $dta->save();
                    }
                }
            }

            if (!empty($request->guests_id)) {
                $interest_array = $request->guests_id;
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {


                    $dta = new TaskGuest();
                    $dta->user_id = $interest_array[$i];
                    $dta->task_id = $inserted_id;
                    $dta->account_id = auth()->user()->account_id;
                    $dta->save();
                }

            }

            if (!empty($request->tags_id)) {
                $interest_array = $request->tags_id;
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {

                    $tag = Tag::where('id', $interest_array[$i])->first();
                    if (!empty($tag) && !empty($request->task_category_id)) {
                        $tag1 = Tag::where('tag_name', $tag->tag_name)->where('cat_id', $request->task_category_id)->first();
                        //  dd($tag1);
                        if (empty($tag1)) {
                            $t1 = new Tag();
                            $t1->tag_name = $tag->tag_name;
                            $t1->cat_id = $request->task_category_id;
                            $t1->account_id = auth()->user()->account_id;
                            $t1->save();
                        }

                        $tag2 = Tag::where('tag_name', $tag->tag_name)->where('cat_id', $request->task_category_id_two)->first();
                        if (empty($tag2) && !empty($request->task_category_id_two)) {
                            $t2 = new Tag();
                            $t2->tag_name = $tag->tag_name;
                            $t2->cat_id = $request->task_category_id_two;
                            $t2->account_id = auth()->user()->account_id;
                            $t2->save();
                        }
                    }

                    $dta = new TaskTag();
                    $dta->tag_id = $interest_array[$i];
                    $dta->task_id = $inserted_id;
                    $dta->account_id = auth()->user()->account_id;
                    $dta->save();
                }

            }


            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' hat ein Post-it erstellt';
            $log->log_user_id = Auth::user()->id;
            $log->log_task_id = $data->id;
            $log->account_id = auth()->user()->account_id;
            $log->save();
            DB::commit();
            return response()->json([
                'message' => 'task Added Successfully',
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);
        }
    }
    /*
     *  params id = the task id
     * data in body
     * no query params
     *  return updated task
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'task_title' => 'required|string|max:60',
                'task_desc' => 'required',
                'task_category_id' => 'required',
                'task_responsible' => 'required',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            DB::beginTransaction();
            $data = Task::find($id);
            $data->task_title = $request->task_title;
            $data->task_desc = $request->task_desc;
            $data->task_category_id = $request->task_category_id;
            $data->task_responsible = $request->task_responsible;
            //  $data->task_start_date = $request->task_start_date;
            $data->task_due_date = date('Y-m-d', strtotime($request->task_due_date)); //$request->task_due_date;

            $data->save();
            if (!empty($request->teams_id)) {

                TaskTeam::where('task_id', $id)->delete();
                $interest_array = $request->teams_id;

                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {

                    if ($interest_array[$i] == Auth::user()->id || $interest_array[$i] == $request->task_responsible) {
                        continue;
                    } else {
                        $pres = TaskTeam::where('task_id', $id)->where('user_id', $interest_array[$i])->first();

                        if (!empty($pres)) {
                            continue;
                        } else {
                            $dta = new TaskTeam();

                            $dta->user_id = $interest_array[$i];
                            $dta->task_id = $id;
                            $dta->account_id = auth()->user()->account_id;
                            $dta->save();
                        }
                    }

                }


            }
            $log = new Log();
            $log->log_desc = "The User " . Auth::user()->user_name . ' Updated The Task ' . $data->task_title;
            $log->log_user_id = Auth::user()->id;
            $log->log_task_id = $id;
            $log->account_id = auth()->user()->account_id;
            $log->save();
            DB::commit();

            return response()->json([
                'message' => 'task updated',
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);
        }
    }

    /*
     *  params id = the task id
     * no data in body
     * no query params
     *  return  task with subtasks with comments
     */
    public function getTask($id): JsonResponse
    {

        try {
            $task = Task::where('id', $id)
                ->with(['category:id,category_name,category_color', 'second_category:id,category_name,category_color', 'team.user:id,user_name,image'])
                ->get();
            $subtasks = SubTask::with('added_by')->where('task_id', $id)->where('subtask_user_id' , Auth::user()->id)->with(['task:id,task_title','added_by:id,user_name,image', 'responsible:id,user_name,image'])->get();
            $comments = Comment::where('task_id', $id)->with('user', 'replays')->where('done' , '==' ,0  )->orderBy('id' , 'desc')->get();
            foreach($comments as $comment) {
                $tag_ids = explode("," , $comment->tags);
                $read_by_ids = json_decode($comment->readby);
                $tag_users = User::whereIn('id' , $tag_ids)->select('id','first_name')->get();
                foreach($tag_users as $tag_user) {
                      if(!empty($read_by_ids)) {
                           if(!in_array( $tag_user->id , $read_by_ids)) {
                                $tag_user->seen = 0;
                            }else {
                                $tag_user->seen = 1;
                           }
                      }else {
                        $tag_user->seen = 0;
                    }
                }
                /*if(!empty($read_by_ids )) {
                    $readby_users  = User::whereIn('id' , $read_by_ids)->pluck('first_name');
                }else {
                    $readby_users  = [];
                }*/
                $comment->tags     = $tag_users;
               //$comment->readby   = $readby_users;
                foreach($comment->replays as $replay) {
                    $reply_tag_ids     = explode("," , $replay->tags);
                    $reply_read_by_ids = json_decode($replay->is_read);
                    $reply_tag_users   = User::whereIn('id' , $reply_tag_ids)->pluck('first_name');
                    if(!empty($reply_read_by_ids )) {
                        $reply_readby_users     = User::whereIn('id' , $reply_read_by_ids)->pluck('first_name');
                    }else {
                        $reply_readby_users     = [];
                    }
                    $replay->tags     = $reply_tag_users;
                    $replay->is_read  = $reply_readby_users;
                }

            }
            return response()->json([
                'task' => $task,
                'subtasks' => $subtasks,
                'comments' => $comments,
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    /*
     *  params id = the task id
     *  return response json
     */
    public function destroy($id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
            if ($task->task_status === 2) {
                $task->task_status = 0;
                $task->save();
                return response()->json([
                    'message' => 'Task undeleted',
                    'status' => true,
                ], Response::HTTP_OK);
            }
            DB::beginTransaction();
            $task->task_status = 2;
            $task->save();
            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' Deleted The Task ' . $task->task_title;
            $log->log_user_id = Auth::user()->id;
            $log->log_task_id = $id;
            $log->account_id = auth()->user()->account_id;

            $log->save();
            DB::commit();
            return response()->json([
                'message' => 'Task deleted',
                'status' => true,
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);

        }
    }

    /*
     *  params id = the task id
     *  return  task  comments
     */
    public function taskComments(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make(['id' => $request->route('id')], [
                'id' => 'exists:tasks,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $comments = Comment::where('task_id', $id)->with('user:id,image,user_name', 'replays')->get();
            return response()->json([
                'comments' => $comments,
                'status' => false
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    /*
     *  params id = the task id
     *  mark task as completed
     */
    public function complete(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make(['id' => $request->route('id')], [
                'id' => 'exists:tasks,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $task = Task::findOrFail($id);
            if ($task->task_status === 1) {
                $task->task_status = 0;
                $task->save();
                return response()->json([
                    'message' => 'Task marked as uncompleted',
                    'status' => true,
                ], Response::HTTP_OK);
            }
            $task->task_status = 1;
            $task->save();
            return response()->json([
                'message' => 'Task marked as completed',
                'status' => true,
            ], Response::HTTP_OK);


        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    /*
     *  params id = the task id
     *  data in body  = file (image or pdf)
     *  return  response json
     */
    public function attachment(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment_file' => ['required', 'mimes:pdf,docs,png,jpg,jpeg']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }

            $task = Task::findOrFail($id);
            DB::beginTransaction();
            $comment = new Comment();
            if ($request->hasFile('comment_') &&
                !empty($request->hasFile('comment_file'))) {
                $image = $request->file('comment_file');
                $image_ext = $image->getClientOriginalExtension();
                $path = rand(123456, 999999) . "." . $image_ext;
                $destination_path = public_path('assets/images/comments/');
                $image->move($destination_path, $path);

                if ($image_ext === 'pdf') {
                    $comment->comment_pdf = $path;
                } else {
                    $comment->comment_image = $path;
                }

            }
            $comment->task_id = $id;
            $comment->comment_added_by = Auth::user()->id;
            $comment->tags = $request->tags;
            $comment->save();

            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' het ein Kommentar eingefugt';
            $log->log_user_id = Auth::user()->id;
            $log->log_task_id = $request->task_id;
            $log->save();
            DB::commit();
            event(new NewNotification($log));
            return response()->json([
                'message' => 'comment added successfully',
                'status' => true
            ], Response::HTTP_OK);


        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);
        }
    }

    /*
     *  params id = the task id
     *  data in body  = comment
     * no query params
     *  return  json response
     */
    public function addComment(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'comment' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }

            $task = Task::findOrFail($id);
            DB::beginTransaction();
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->task_id = $id;
            $comment->comment_added_by = Auth::user()->id;
            $comment->tags = implode(",",json_decode($request->tags));
            $comment->save();
            // send notification to mobile
            if(!empty($request->tags)) {
             $this->sendCommentNotify(implode(",",json_decode($request->tags)) , 'New Comment' , $request->comment);
            }
            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' het ein Kommentar eingefugt';
            $log->log_user_id = Auth::user()->id;
            $log->log_task_id = $request->task_id;

            DB::commit();
            event(new NewNotification($log));



            return response()->json([
                'message' => 'comment added successfully',
                'status' => true
            ], Response::HTTP_OK);


        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);
        }

    }

    public function assignUser(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }

            $task = Task::findOrFail($id);
            TaskTeam::create([
                'user_id' => $request->user_id,
                'task_id' => $task->id,
                'account_id' => Auth::user()->account_id

            ]);

            return response()->json([
                'message' => 'user assigned to the task',
                'status' => true
            ], Response::HTTP_OK);


        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function updateResponsible(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }

            $task = Task::findOrFail($id);
            $task->task_responsible = $request->user_id;
            $task->save();

            return response()->json([
                'message' => 'user assigned to the task',
                'status' => true
            ], Response::HTTP_OK);


        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function copyTask($id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
            $task->load('team', 'subtasks');
            $new_task = $task->replicate();
            $new_task->push();


            foreach ($task->getRelations() as $relation => $items) {
                foreach ($items as $item) {
                    unset($item->id);
                    $new_task->{$relation}()->create($item->toArray());
                }
            }

            return response()->json([
                'message' => 'Task copied',
                'task' => $new_task,
                'status' => true
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    private function sendCommentNotify($tags ,$comment_title = null , $comment_body = null) {
        $users      = User::whereIn('id' , explode(',', $tags))->pluck('fcm_token');
        $SERVER_API_KEY = 'AAAAm78oQMI:APA91bGOytrHQyFsqUYjm9p6rtnQA2O-6b8lhfnsJD4IMrbeOOiOfGE9gzPhPp9HYPgMSh3olZ-DKfdgsYnncGuh5K4KD1pzgg3xf9ELjRa1Ma5VNByWNjNdOmFE7Qr-nTh035hFBBWd';
        $data = [
         "registration_ids"     =>  $users,
         "notification"         => [
                                      "title" => $comment_title,
                                      "body" => $comment_body  ,
                                      "content_available" => true,
                                      "priority" => "high",
         ],
         "data"                 =>  [
                                      "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                                      "type"   => "remember",
         ],
        ];
        $dataString = json_encode($data);
        $headers = [
          'Authorization: key=' . $SERVER_API_KEY,
          'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);


       /*echo $response;*/
    }

    public function updatereplay(Request $request):JsonResponse
    {
        try {
            $replay = Replay::find($request->replay_id);
            if (empty($replay->is_read) || $replay->is_read == NULL) {
                $replay->is_read = json_encode(array(Auth::user()->id));
                $replay->save();
                return response()->json([
                    'msg' => 'Replay Updated Successfuly ',
                    'status' => true
                ], Response::HTTP_OK);
            } else {
                $arr = json_decode($replay->is_read);
                if (!in_array(Auth::user()->id, $arr)) {
                    array_push($arr, Auth::user()->id);
                    $replay->is_read = json_encode($arr);
                    $replay->save();
                    return response()->json([
                        'msg' => 'Replay Updated Successfuly ',
                        'status' => true
                    ], Response::HTTP_OK);
                }
            }
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }


    public function filterUserhistorySubtasks(Request $request)
    {
        if (Auth::user()->role == 2) {
            //Display  Admin Filte
            $users = User::where('account_id', auth()->user()->account_id)->paginate(config('constants.PER_PAGE'));
            $gender = $request->gender;
            if (empty($gender)) {
                $gender = "list";
            }
            $status = 0;
            $subtask_status2 = $request->subtask_status2;
            $tasksids = TaskGuest::where('account_id', auth()->user()->account_id)->where('user_id', Auth::user()->id)->pluck('task_id');
            if ($request->type == "date_filter") {


                $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d', strtotime($request->end_due_date));


                if (empty($request->start_due_date)) {
                    $start_due_date = null;
                }
                if (empty($request->end_due_date)) {
                    $end_due_date = null;
                }

                if (empty($request->end_due_date) && empty($request->start_due_date)) {
                    $end_due_date = null;
                    $start_due_date = null;
                }

                $subtask_user_id = $request->subtask_user_id;

                if (!empty($start_due_date) && !empty($end_due_date)) {
                    $user_subtasks = SubTask::with('history')->with('task.category')->whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                        $query->whereBetween('created_at', [$start_due_date, $end_due_date]);
                    })->where('subtask_user_id', Auth::user()->id)->paginate(config('constants.PER_PAGE'));

                }
                return  response()->json([
                    'user_subtasks' => $user_subtasks ,
                    'users' => $users ,
                    'gender' => $gender ,
                    'status' => true ,
                ] , Response::HTTP_OK);
            }
        } else {
            //Display  Admin Filte
            $users = User::where('account_id', auth()->user()->account_id)->paginate(config('constants.PER_PAGE'));
            $gender = $request->gender;
            if (empty($gender)) {
                $gender = "list";
            }
            $status = 0;
            $subtask_status2 = $request->subtask_status2;
            $tasksids = TaskGuest::where('account_id', auth()->user()->account_id)->where('user_id', Auth::user()->id)->pluck('task_id');
            if ($request->type == "date_filter") {

                $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d', strtotime($request->end_due_date));


                if (empty($request->start_due_date)) {
                    $start_due_date = null;
                }
                if (empty($request->end_due_date)) {
                    $end_due_date = null;
                }

                if (empty($request->end_due_date) && empty($request->start_due_date)) {
                    $end_due_date = null;
                    $start_due_date = null;
                }

                $subtask_user_id = $request->subtask_user_id;
                //if user and two dates
                if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && $start_due_date != $end_due_date) {

                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::with('added_by')->with('history')->with('task.category')->whereBetween('created_at', [$start_due_date, $end_due_date])->paginate(config('constants.PER_PAGE'));

                    } else {
                        $user_subtasks = SubTask::with('added_by')->with('history')->with('task.category')->whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                            $query->whereBetween('created_at', [$start_due_date, $end_due_date]);
                        })->where('subtask_user_id', $subtask_user_id)->paginate(config('constants.PER_PAGE'));
                    }

                } // when two dates only is not  equal two us
                else if (empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && $start_due_date != $end_due_date) {

                    $user_subtasks = SubTask::with('added_by')->with('history')->with('task.category')->with('history')->whereBetween('created_at', [$start_due_date, $end_due_date])->paginate(config('constants.PER_PAGE'));
                } // WHEN Start  Date Is Equal  To  End Date All Dates Between It
                else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && $start_due_date == $end_due_date) {
                    if($subtask_user_id == 'all')
                    {
                        $user_subtasks = SubTask::with('added_by')->with('history')->with('task.category')->whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                            $query->whereBetween('created_at', [$start_due_date . " 00:00:00", $end_due_date . " 23:59:59"]);
                        })->paginate(config('constants.PER_PAGE'));

                    }
                    else
                    {
                        $user_subtasks = SubTask::with('added_by')->with('history')->with('task.category')->whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                            $query->whereBetween('created_at', [$start_due_date . " 00:00:00", $end_due_date . " 23:59:59"]);
                        })->where('subtask_user_id', $subtask_user_id)->paginate(config('constants.PER_PAGE'));
                    }


                }


                return  response()->json([
                    'user_subtasks' => $user_subtasks ,
                    'users' => $users ,
                    'gender' => $gender ,
                    'status' => true ,
                ] , Response::HTTP_OK);


            }
            if ($request->type == "user_filter") {

                $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d', strtotime($request->end_due_date));


                if (empty($request->start_due_date)) {
                    $start_due_date = null;
                }
                if (empty($request->end_due_date)) {
                    $end_due_date = null;
                }

                if (empty($request->end_due_date) && empty($request->start_due_date)) {
                    $end_due_date = null;
                    $start_due_date = null;
                }

                $subtask_user_id = $request->subtask_user_id;

                if (!empty($subtask_user_id) && empty($start_due_date) && empty($end_due_date)) {
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::with('added_by')->with('history')->with('task.category')->with('history')->where('account_id', auth()->user()->account_id)->paginate(config('constants.PER_PAGE'));
                    } else {
                        $user_subtasks = SubTask::with('added_by')->with('history')->with('task.category')->with('history')->where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->paginate(config('constants.PER_PAGE'));
                    }
                }
            }
        }
        return  response()->json([
            'user_subtasks' => $user_subtasks ,
            'users' => $users ,
            'gender' => $gender ,
            'status' => true ,
        ] , Response::HTTP_OK);

    }

    public function updateTaskfield(Request $request)
    {

       /* DB::beginTransaction();*/
        $id =  (int)$request->task_id;
        $data = Task::find($id);
        $cat_id = $data->task_category_id;

        if ($request->field_name == 'teams_id') {

            if (!empty($request->field_val)) {

                $request->field_val = json_decode($request->field_val) ;

                TaskTeam::where('task_id', $id)->delete();

                $interest_array = $request->field_val;


                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {
                    if ($interest_array[$i] == Auth::user()->id || $interest_array[$i] == $data->task_responsible) {
                        return response()->json([
                            'messages' => 'You cant  add  Responsaple  or  youself  ' ,
                            'status' => false
                        ], Response::HTTP_BAD_REQUEST);
                        continue;
                    } else {
                        $pres = TaskTeam::where('task_id', $id)->where('user_id', $interest_array[$i])->first();

                        if (!empty($pres)) {
                            continue;
                        } else {

                            $dtar = new TaskTeam();
                            $dtar->user_id = $interest_array[$i];
                            $dtar->task_id = $id ;
                            $dtar->account_id = auth::guard('api')->user()->account_id;
                            $dtar->save();
                        }
                    }

                }
                return response()->json([
                    'messages' => 'data Added  Successfuly  ' ,
                    'status' => true
                ], Response::HTTP_OK);


                $log = new Log();
                $log->log_desc = Auth::user()->user_name . ' hat Anderungen in Post-it ' . $data->task_title . " ubernommen";
                $log->log_user_id = Auth::user()->id;
                $log->log_task_id = $id;
                $log->account_id = auth()->user()->account_id;
                $log->save();
                $log->user_name = Auth::user()->user_name;
                $log->user_image = Auth::user()->image;
                //real time event
                event(new NewNotification($log));





            } else {
                TaskTeam::where('task_id', $id)->delete();
                $log = new Log();
                $log->log_desc = Auth::user()->user_name . ' hat Anderungen in Post-it ' . $data->task_title . " ubernommen";
                $log->log_user_id = Auth::user()->id;
                $log->log_task_id = $id;
                $log->account_id = auth()->user()->account_id;
                $log->save();
                $log->user_name = Auth::user()->user_name;
                $log->user_image = Auth::user()->image;
                //real time event
                event(new NewNotification($log));
            }


        }


        else if ($request->field_name == 'guests_id') {

            if (!empty($request->field_val)) {
                TaskGuest::where('task_id', $id)->delete();
                $interest_array = $request->field_val;
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {


                    $pres = TaskGuest::where('task_id', $id)->where('user_id', $interest_array[$i])->first();
                    if (!empty($pres)) {
                        continue;
                    } else {
                        $dta = new TaskGuest();

                        $dta->user_id = $interest_array[$i];
                        $dta->task_id = $id;
                        $dta->account_id = auth()->user()->account_id;
                        $dta->save();
                    }
                }


                $log = new Log();
                $log->log_desc = Auth::user()->user_name . ' hat Anderungen in Post-it ' . $data->task_title . " Besucher";
                $log->log_user_id = Auth::user()->id;
                $log->log_task_id = $id;
                $log->account_id = auth()->user()->account_id;
                $log->save();
                $log->user_name = Auth::user()->user_name;
                $log->user_image = Auth::user()->image;
                //real time event
                event(new NewNotification($log));

            } else {
                TaskGuest::where('task_id', $id)->delete();
                $log = new Log();
                $log->log_desc = Auth::user()->user_name . ' hat Anderungen in Post-it ' . $data->task_title . " Besucher";
                $log->log_user_id = Auth::user()->id;
                $log->log_task_id = $id;
                $log->account_id = auth()->user()->account_id;
                $log->save();
                $log->user_name = Auth::user()->user_name;
                $log->user_image = Auth::user()->image;
                //real time event
                event(new NewNotification($log));
            }


        }
        else if ($request->field_name == 'tags_id') {

            if (!empty($request->field_val)) {
                TaskTag::where('task_id', $id)->delete();
                $interest_array = $request->field_val;
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {

                    $tag = Tag::where('id', $interest_array[$i])->first();
                    if (!empty($tag)) {
                        $tag1 = Tag::where('tag_name', $tag->tag_name)->where('cat_id', $data->task_category_id)->first();
                        if (empty($tag1) && !empty($data->task_category_id)) {


                            $t1 = new Tag();
                            $t1->tag_name = $tag->tag_name;
                            $t1->cat_id = $data->task_category_id;
                            $t1->account_id = auth()->user()->account_id;
                            $t1->save();
                        }

                        $tag2 = Tag::where('tag_name', $tag->tag_name)->where('cat_id', $data->task_category_id_two)->first();
                        if (empty($tag2) && !empty($data->task_category_id_two)) {

                            $t2 = new Tag();
                            $t2->tag_name = $tag->tag_name;
                            $t2->cat_id = $data->task_category_id_two;
                            $t2->account_id = auth()->user()->account_id;
                            $t2->save();
                        }
                    }

                    $pres = TaskTag::where('task_id', $id)->where('tag_id', $interest_array[$i])->first();
                    if (!empty($pres)) {
                        continue;
                    } else {
                        $dta = new TaskTag();

                        $dta->tag_id = $interest_array[$i];
                        $dta->task_id = $id;
                        $dta->account_id = auth()->user()->account_id;
                        $dta->save();
                    }
                }


                $log = new Log();
                $log->log_desc = Auth::user()->user_name . ' hat Anderungen in Post-it ' . $data->task_title . " Schild";
                $log->log_user_id = Auth::user()->id;
                $log->log_task_id = $id;
                $log->account_id = auth()->user()->account_id;
                $log->save();
                $log->user_name = Auth::user()->user_name;
                $log->user_image = Auth::user()->image;
                //real time event
                event(new NewNotification($log));

            } else {
                TaskTag::where('task_id', $id)->delete();
                $log = new Log();
                $log->log_desc = Auth::user()->user_name . ' hat Anderungen in Post-it ' . $data->task_title . " Schild";
                $log->log_user_id = Auth::user()->id;
                $log->log_task_id = $id;
                $log->account_id = auth()->user()->account_id;
                $log->save();
                $log->user_name = Auth::user()->user_name;
                $log->user_image = Auth::user()->image;
                //real time event
                event(new NewNotification($log));
            }


        }
        else {

            $field_name = $request->field_name;
            if ($field_name == 'task_due_date') {
                $data->$field_name = date('Y-m-d', strtotime($request->field_val));
            } else {
                $data->$field_name = $request->field_val;
            }
            $data->save();

            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' hat Anderungen in Post-it ' . $data->task_title . " ubernommen";
            $log->log_user_id = Auth::user()->id;
            $log->log_task_id = $id;
            $log->account_id = auth()->user()->account_id;
            $log->save();
            $log->user_name = Auth::user()->user_name;
            $log->user_image = Auth::user()->image;
            //real time event
            event(new NewNotification($log));
        }
  //    DB::commit();

        return response()->json([
            'messages' => 'Data Updated Successfuly 2  ' ,
            'status' => true
        ] , Response::HTTP_OK );


        $task = Task::find($id);
        if ($request->field_name == 'task_category_id' && $request->field_val != $cat_id) {
            return response()->json(['options' => 'no', 'options2' => $data]);
        } else {
            return response()->json(['options' => $data]);
        }
    }

    public function unmarkComplete(Request $request)
    {
        $id = $request->task_id;
        $data = Task::find($id);
        $data->task_status = 0;
        $data->save();
        $log = new Log();
        $log->log_desc = Auth::user()->user_name . 'Mark The Task ' . $data->task_title . 'UnCompleted';
        $log->log_user_id = Auth::user()->id;
        $log->log_task_id = $id;
        $log->account_id = auth()->user()->account_id;
        $log->save();
        $log->user_name = Auth::user()->user_name;
        $log->user_image = Auth::user()->image;
        //real time event
        event(new NewNotification($log));
        $msg = 'Data UnCompleted Successfully';
        return response()->json([
            "status" => true,
            "msg" => $msg
        ], 200);
    }


    public function undelete(Request $request)
    {
        $id = $request->task_id;
        $data = Task::find($id);
        $data->task_status = 0;
        $data->save();
        $log = new Log();
        $log->log_desc = Auth::user()->user_name . ' Restore The Task ' . $data->task_title;
        $log->log_user_id = Auth::user()->id;
        $log->log_task_id = $id;
        $log->account_id = auth()->user()->account_id;

        $log->save();

        $log->user_name = Auth::user()->user_name;
        $log->user_image = Auth::user()->image;
        //real time event
        event(new NewNotification($log));

        $msg = 'Data Restored Successfully';
        return response()->json([
            "status" => true,
            "msg" => $msg
        ], 200);
    }


}
