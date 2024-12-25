<?php

namespace App\Http\Controllers\Api;

use App\Events\ComentsNotification;
use App\Events\ReplayNotification;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Replay;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\SubTask;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\Log;
use App\Helpers\CustomResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Events\NewNotification;
use Illuminate\Validation\Rule;
use function GuzzleHttp\Promise\task;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class SubtaskController extends Controller
{

    protected $response;

    /**
     * @param $response
     */
    public function __construct(CustomResponse $response)
    {
        $this->response = $response;
    }

    public function mySubtasks(Request $request): JsonResponse
    {
        try {

            $validator = Validator::make($request->all(), [

                 'subtask_start_date'  => 'present|nullable|date',
                 'subtask_due_date'    => 'present|nullable|date',
                 'subtask_status'      => ['present', Rule::in([0,1,2]), 'nullable'],
                 'subtask_priority'    => 'nullable',
                 'subtask_order'       => 'nullable',

            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }

            $subtask_start_date = date('Y-m-d H:i:s', strtotime($request->subtask_start_date));
            $subtask_due_date = date('Y-m-d H:i:s', strtotime($request->subtask_due_date));
            if($request->subtask_status == 2){
                $status = 0;
            }else {
                $status = 1;
            }
            $user = Auth::user();

            $order     = $request->subtask_order;

                if (empty($order)) {
                    if (

                        !empty($request->subtask_due_date) &&
                        !empty($request->subtask_start_date)&&
                        isset($request->subtask_status) &&
                        !empty($request->subtask_status)
                    ) {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->whereBetween('created_at', [$subtask_start_date, $subtask_due_date])
                        ->where('subtask_status', $status)
                            ->orderBy('created_at', 'DESC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    } elseif (
                        !empty($request->subtask_due_date) &&
                        !empty($request->subtask_start_date)
                    ) {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->whereBetween('created_at', [$subtask_start_date, $subtask_due_date])
                            ->orderBy('created_at', 'DESC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    } elseif (isset($request->subtask_status) && !empty($request->subtask_status)) {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->where('subtask_status', $status)
                            ->orderBy('created_at', 'DESC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    } else {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->orderBy('created_at', 'DESC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    }
                }else {
                    if (

                        !empty($request->subtask_due_date) &&
                        !empty($request->subtask_start_date)&&
                        isset($request->subtask_status) &&
                        !empty($request->subtask_status)
                    ) {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->whereBetween('created_at', [$subtask_start_date, $subtask_due_date])
                        ->where('subtask_status', $status)
                        ->orderBy('suborder', 'ASC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    } elseif (
                        !empty($request->subtask_due_date) &&
                        !empty($request->subtask_start_date)
                    ) {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->whereBetween('created_at', [$subtask_start_date, $subtask_due_date])
                        ->orderBy('suborder', 'ASC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    } elseif (isset($request->subtask_status) && !empty($request->subtask_status)) {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->where('subtask_status', $status)
                        ->orderBy('suborder', 'ASC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    } else {
                        $subtasks = SubTask::where('subtask_user_id', $user->id)
                        ->where('account_id', $user->account_id)
                        ->orderBy('suborder', 'ASC')
                        ->with('task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image')
                        ->paginate(15);
                    }
                }

            return response()->json([
                'subtasks' => $subtasks,
                'status' => true
            ]);
        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }

    public function orderadminsubtasks(Request $request)
    {
        $data  =$request->slecteddata ;
        $i = 1 ;
        foreach ($data as $order)
        {
            $neworder = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status',0)->where('id',$order)->first();
            $neworder->suborder = $i ;
            $neworder->save() ;
            $i++ ;
        }
        return response('Update Successfully.', 200);
    }


    public function  historydescription(Request $request)
    {
        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
        if (isset($request->start_due_date) && isset($request->end_due_date)) {
            if ($request->start_due_date == $request->end_due_date) {

                $history = TaskHistory::where(['task_id' => $request->task_id])->where(DB::raw('Date(created_at)'), '=', $start_due_date)->paginate(config('constants.PER_PAGE'));
            }
            else
            {
                $history = TaskHistory::where(['task_id' => $request->task_id])->whereBetween(DB::raw('Date(created_at)'), [$start_due_date, $end_due_date])->paginate(config('constants.PER_PAGE'));
            }
        }
        else {
            $history = TaskHistory::where(['task_id' => $request->task_id])->paginate(config('constants.PER_PAGE'));
        }

        $timeonsecondes = 0 ;

        function timeToSeconds(string $time)
        {
            $arr = explode(':', $time);
            if (count($arr) === 3) {
                return $arr[0] * 3600 + $arr[1] * 60 + $arr[2];
            }
            return $arr[0] * 60 + $arr[1];
        }
        $total = [] ;
        foreach($history as $data)
        {


            $start_time  = timeToSeconds( date_format($data->created_at ,'h:i:s') );
            $startonseconds  =  $start_time - $data->Time ;
            $hours_start = floor($startonseconds / 3600);
            $mins_start = floor($startonseconds / 60 % 60);
            $secs_start = floor($startonseconds % 60);
            $startformat  = sprintf('%02d:%02d:%02d', $hours_start, $mins_start, $secs_start);


            $dates['id'] = $data->id ;
            $dates['start'] =  $startformat  ;
            $dates['end'] = date_format( $data->created_at ,'h:i:s')  ;

            $hours = floor($data->Time / 3600);
            $mins = floor($data->Time / 60 % 60);
            $secs = floor($data->Time % 60);
            $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


            $dates['total_time'] =  $timeFormat  ;

            $dates['date'] = date_format( $data->created_at ,'d.m.Y');
            array_push($total ,$dates);

        }
     if(!empty($dates)) {
         return response()->json([
             'data' => $total,
             'status' => true,
         ], Response::HTTP_OK);
     }
     else{
         return response()->json([
             'msg' =>'No Data For This Task ',
             'status' => false,
         ], Response::HTTP_BAD_REQUEST);
     }

    }
    public function index(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'subtask_user_id' => 'present|exists:users,id|nullable',
                'subtask_status' => ['present', Rule::in([0, 1]), 'nullable'],
                'subtask_start_date' => 'present|nullable|date',
                'subtask_due_date' => 'present|nullable|date',
                'date_filter' => ['present', Rule::in(['created', 'due', 'completed']), 'nullable']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }


            $subtask = SubTask::where('account_id', Auth::user()->account_id);

            $subtask_start_date = date('Y-m-d H:i:s', strtotime($request->subtask_start_date));
            $subtask_due_date = date('Y-m-d H:i:s', strtotime($request->subtask_due_date));
            if (isset($request->subtask_status) && !empty($request->subtask_status)) {
                $subtask->where('subtask_status', $request->subtask_status);
            }
            if (
                !empty($request->subtask_due_date) &&
                !empty($request->subtask_start_date)
            ) {

                if ($request->date_filter === 'created') {
                    $subtask->whereBetween('created_at', [$subtask_start_date, $subtask_due_date]);

                }
                if ($request->date_filter === 'due') {
                    $subtask->whereBetween('subtask_due_date', [$subtask_start_date, $subtask_due_date]);


                }
                if ($request->date_filter === 'completed') {
                    $subtask->whereBetween('subtask_completed_at', [$subtask_start_date, $subtask_due_date]);


                }

                if ($request->date_filter === null) {
                    $subtask->whereBetween('created_at', [$subtask_start_date, $subtask_due_date]);

                }

            }

            if (Auth::user()->role === 1) {
                if (!empty($request->subtask_user_id)) {
                    $subtask->where('subtask_user_id', $request->subtask_user_id);
                } else {
                    $subtask->where('subtask_user_id', Auth::user()->id);
                }

            } else {
                $subtask->where('subtask_user_id', Auth::user()->id);
            }

            if (
                empty($request->subtask_due_date) &&
                empty($request->subtask_start_date)&&
                empty($request->subtask_status) &&
                empty($request->date_filter) &&
                empty($request->subtask_user_id)
            ){
                $subtask->whereDate('created_at', Carbon::today());
            }

            $subtasks = $subtask->with('task:id,task_title')->get();


            return response()->json([
                'subtasks' => $subtasks,
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }


    }
    /**Store Comment Image */

    public  function  storecommentImage(Request $request)
    {
            try {
                $validator = Validator::make($request->all(),[
                    'task_id' => 'required',
                ]);

                $task = Task::find($request->task_id);
                DB::beginTransaction();
                $data =new Comment();

                if ($request->hasFile('comment_image') && !empty($request->hasFile('comment_image'))) {
                    $image = $request->file('comment_image');
                    $image_ext = $image->getClientOriginalExtension();
                    $path = rand(123456, 999999) . "." . $image_ext;
                    $destination_path = public_path('assets/images/comments/');
                    $image->move($destination_path, $path);

                    if($image_ext == 'pdf') {
                        $data->comment_pdf = $path;
                    }else {
                        $data->comment_image = $path;
                    }
                }

                $data->task_id = $request->task_id;
                $data->comment_added_by = Auth::user()->id;
                $data->subtask_id  = $request->subtask_id;
                $data->tags = $request->tags ;

                DB::commit();
                $data->save();

                event(new ComentsNotification($data));

                $comments = Comment::where('task_id',$request->task_id)->with('user')->orderBy('id' , 'DESC')->get();
                return  response()->json([
                    'msg' => 'Image  Added Successfuly' ,
                    'status' => true
                ], Response::HTTP_OK);

            }catch(Exception $e) {
                return  response()->json([
                    'msg' => 'Error on upload ' ,
                    'status' => true
                ], Response::HTTP_BAD_REQUEST);
            }
    }

    /*Store Replay of Comments */
    public function storereplay(Request $request )
    {

        $data = $request->all() ;
        $replay =  new Replay() ;

        $replay->comment_id = $data['comment_id'] ;
        $replay->replay     =     $data['replay_comment'];
        $replay->added_by   =   Auth::user()->first_name;

        $replay->added_by_id   =  auth::user()->id;

        $replay->task_id   = $data['task_id'];

        $newtags = implode(',' , json_decode($data['tags'])) ;
        $replay->tags   = $newtags;

        $replay->comment_author   = $data['comment_author'];

        $replay->save() ;
        $lastinsertedid  =  $replay->id ;

        $replays = Replay::where('comment_id' , $data['comment_id'] )->get() ;

        $count_replays =  $replays->count() ;
        //Real  Time Notfation Replaying

        $replay_data = [
            'comment_id' =>   $data['comment_id'] ,
            'replay_id'   =>  $replay->id ,
            'added_by'  => Auth::user()->first_name ,
            'task_id'   =>  $data['task_id'] ,
            'comment_author'  => $data['comment_author'] ,
            'user_image' =>  auth::user()->image ,
            'comment_date' => date("d.m.Y", strtotime(Carbon::now())),
            'comment_time' => date("d.m.Y", strtotime(Carbon::now()))
        ];

       return  response()->json([
           'msg' => 'replay Added Successfuly' ,
           'status' => true
       ], Response::HTTP_OK);
    }

    public function  viewreplays(Request $request)
    {
        $allreplays = Replay::with('user')->where('comment_id' , $request->comment_id )->get();

        $alltags = [] ;
        foreach ($allreplays as $replay )
        {

            $readusers =  json_decode($replay->is_read) ;
            $replay->is_read = $readusers ;

            $tags = explode(',', $replay->tags);

            foreach($tags as  $user)
            {
                $tagusers = \App\Models\User::where(['id'=>$user])->first() ;

                if(!empty($tagusers)){
                    $alltags[] =   [
                        'id'=> $tagusers->id ,
                        'first_name' => $tagusers->first_name ,
                        'done' =>  (!empty($readusers)) ?  (in_array( $tagusers->id , $readusers)) ? true : false : false

                    ] ;

                }

            }

            $replay->tags  = $alltags ;
            $replays[] = $replay ;
            $alltags = [] ;
        }





        if(count($replays) > 0 ) {
            return response()->json([
                'replays' => $replays,
                'status' => true
            ] , Response::HTTP_OK);
        }
        else
        {
            return response()->json([
                'msg' => 'No Replays Found ',
                'status' => false
            ],Response::HTTP_BAD_REQUEST);
        }
    }
    public function deletereplay(Request $request)
    {
        $id = $request->id;
        $data = Replay::find($id);
        if(!empty($data)) {
            $data->delete();
            return response()->json([
                'msg' => 'Replay Deleted Successfuly ',
                'status' => true
            ] , Response::HTTP_OK);
        }
        else
        {
            return response()->json([
                'msg' => 'No Replay Found ',
                'status' => false
            ],Response::HTTP_BAD_REQUEST);
        }
    }
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'subtask_title' => 'required',
                'task_id' => 'required|exists:tasks,id',
                'subtask_user_id' => 'present|nullable|exists:users,id',
                'subtask_due_date' => 'present|nullable|date',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            DB::beginTransaction();
            $data = new SubTask();
            $data->subtask_title = $request->subtask_title;
            $data->task_id = $request->task_id;
            $data->subtask_user_id = $request->subtask_user_id;
            $data->subtask_added_by = Auth::user()->id;
            $data->subtask_due_date = $request->subtask_due_date;
            $data->account_id = auth()->user()->account_id;
            $data->suborder  =$data->max('suborder') + 1  ;
            //dd($data->max('suborder') + 1) ;
            $data->save();
            $log = new Log();
            $log->log_desc = "The User " . Auth::user()->user_name . ' Add A New Unteraufgabe ';
            $log->log_user_id = Auth::user()->id;
            $log->log_subtask_id = $data->id;
            $log->account_id = auth()->user()->account_id;
            $log->log_task_id = $request->task_id;

            $log->save();
            DB::commit();
            event(new NewNotification($log));
            return response()->json([
                'subtask' => $data,
                'status' => true
            ], Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);

        }
    }

    public function find($id): JsonResponse
    {
        try {
            $subtask = SubTask::with('task:id,task_title')->findOrFail($id);
            return response()->json([
                'subtask' => $subtask,
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);

        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $subtask = SubTask::findOrFail($id);
            $subtask->delete();
            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' hat das Unteraufgabe ' . $subtask->subtask_title . ' geloscht';
            $log->log_user_id = Auth::user()->id;
            $log->log_subtask_id = $id;
            $log->account_id = auth()->user()->account_id;
            $log->log_task_id = $subtask->id;

            $log->save();
DB::commit();
            //real time event
            event(new NewNotification($log));
            return response()->json([
                'message' => 'subtask deleted',
                'status' => true,
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {

            DB::rollBack();
            return $this->response->internalError($exception);

        }
    }

    public function toggleCompleted($id): JsonResponse
    {
        try {
            $subtask = SubTask::findOrFail($id);

            DB::beginTransaction();
            if ($subtask->subtask_completed_at) {
                $subtask->subtask_completed_at = null;
                $subtask->subtask_status =0;
                $subtask->save();
                $log = new Log();
                $log->log_desc = Auth::user()->user_name . ' hat eine Unteraufgabe als nicht erledigt markiert ';
                $log->log_user_id = Auth::user()->id;
                $log->log_subtask_id = $id;
                $log->account_id = auth()->user()->account_id;
                $log->save();
                DB::commit();

                return response()->json([
                    'message' => 'subtask uncompleted ',
                    'status' => true,
                ], Response::HTTP_OK);
            }
            if ($subtask->timer ===1){
                return response()->json([
                    'message' => 'stop timer first',
                    'status' => false,
                ], Response::HTTP_BAD_REQUEST);
            }

            $subtask->subtask_status =1;
            $subtask->subtask_completed_at = Carbon::now()->addHour(2);
            $subtask->save();
            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' hat eine Unteraufgabe als erledigt markiert ';
            $log->log_user_id = Auth::user()->id;
            $log->log_subtask_id = $id;
            $log->account_id = auth()->user()->account_id;
            $log->save();
            DB::commit();

            return response()->json([
                'message' => 'subtask completed status updated ',
                'status' => true,
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);

        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        /*$validator = Validator::make($request->all(), [
            'subtask_title' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false
            ], Response::HTTP_BAD_REQUEST);
        }*/

        try {
            $subtask = SubTask::findOrFail($id);
            if(!empty($request->subtask_title)) {
                $subtask->subtask_title = $request->subtask_title;
            }
            if(!empty($request->subtask_due_date)) {
                $subtask->subtask_due_date = $request->subtask_due_date;
            }
            $subtask->save();
            return response()->json([
                'subtask' => $subtask,
                'message' => 'updated successfully',
                'status' => true
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
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
                    'status' => false,
                ], Response::HTTP_BAD_REQUEST);

            }

            $subtask = SubTask::findOrFail($id);
            $subtask->subtask_user_id = $request->user_id;
            $subtask->save();
            return response()->json([
                'message' => 'user assigned',
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);

        }


    }

    public function updateDueDate(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'due_date' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false,
                ], Response::HTTP_BAD_REQUEST);

            }

            DB::beginTransaction();
            $subtask = SubTask::findOrFail($id);
            $subtask->subtask_due_date = $request->due_date;
            $subtask->save();
            $log= new Log();
            $log->log_desc = Auth::user()->user_name . ' hat eine Anderungen in Unteraufgabe ' . $subtask->subtask_title . ' ubernommen';
            $log->log_user_id = Auth::user()->id;
            $log->log_subtask_id = $request->subtask_id;
            $log->account_id = auth()->user()->account_id;
            $log->log_task_id = $subtask->task_id;

            $log->save();
            DB::commit();
            return response()->json([
                'message' => 'due date updated',
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);

        }
    }


    public function start($id): JsonResponse
    {
        try {
            $subtasks_count = SubTask::where('subtask_user_id', Auth::user()->id)->where('timer',1)->count();

            if ($subtasks_count >0){
                return response()->json([
                    'message' => 'cannot start Two subtask in same time',
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $data = SubTask::findOrFail($id);

            if (Auth::user()->id !== $data->subtask_user_id) {
                return response()->json([
                    'message' => 'unauthorized action',
                    'status' => false
                ], Response::HTTP_UNAUTHORIZED);
            }

            $data->timer = 1;
            $data->start_time_system = date("Y-m-d H:i:s");  //Time From Server Germania
            $data->save();
            return response()->json([
                'message' => 'Task started',
                'status' => false
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);

        }
    }

    public function store_timer(Request $request, $id): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'time' => 'required|date_format:H:i:s'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $time = $request->time;
            DB::beginTransaction();
            $data = SubTask::findOrFail($id);
            $data->timer = 0;
            if (!$data->subtask_time) {
                $data->subtask_time = '00:00:00';
            }
            $data->save();
            $created = new Carbon($data->start_time_system);
            $now = Carbon::now();
            $difference = ($created->diff($now));
            $hours = $difference->h;
            $minutes = $difference->i;
            $seconds = $difference->s;
            $start_time = array_map('intval', explode(':', $data->subtask_time));
            $stop_time = array_map('intval', explode(':', $time));
            /*History Time*/
            $xhours = $stop_time[0];
            $xminutes = $stop_time[1];
            $xseconds = $stop_time[2];

            $str_time = $xhours . ':' . $xminutes . ':' . $xseconds;   // '170: 125: 130';
            //convert on seconds
            $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
            $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
            $hours = $start_time[0] + $hours;
            $minutes = $start_time[1] + $minutes;
            $seconds = $start_time[2] + $seconds;
            $param = $hours . ':' . $minutes . ':' . $seconds;   // '170: 125: 130';
            $hms = array_map('intval', explode(':', $param));
            $hms[1] += floor($hms[2] / 60);
            $hms[2] %= 60;
            $hms[0] += floor($hms[1] / 60);
            $hms[1] %= 60;
            ///dd(implode(': ', $hms));
            if ($hms[0] < 10) {
                $hms[0] = '0' . $hms[0];
            }
            if ($hms[1] < 10) {
                $hms[1] = '0' . $hms[1];
            }
            if ($hms[2] < 10) {
                $hms[2] = '0' . $hms[2];
            }
            $data->subtask_time = implode(': ', $hms);
            $taskshistory = new TaskHistory();
            $taskshistory->task_id = $data->id;
            $taskshistory->user_id = $data->subtask_user_id;
            $taskshistory->Time = $time_seconds;
            $taskshistory->save();
            $data->save();

            DB::commit();
            return response()->json([
                'subtask_history' => $hms[0] . ':' . $hms[1] . ':' . $hms[2],
                'status' => true
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);

        }

    }

    public function timeTracking($id): JsonResponse
    {
        try {
            $subtask_history = TaskHistory::where('task_id', $id)->get();
            return response()->json([
                'subtasks' => $subtask_history,
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }

    public function copy(Request $request, $id):JsonResponse
    {
        try {
            $validartor = Validator::make($request->all(),[
                'task_id' =>'required'
            ]);
            if ($validartor->fails()){
                return response()->json([
                    'message'=>$validartor->errors()->first(),
                    'status'=> false
                ],Response::HTTP_BAD_REQUEST);
            }
            $subtask = SubTask::findOrFail($id);
            $task_id = Task::findOrFail($request->task_id);
            $replicated = $subtask->replicate();
            $replicated->timer =0;
            $replicated->timer_value ='00:00:00';
            $replicated->task_id = $request->task_id;
            $replicated->save();
            return response()->json([
                'message' =>'subtask copied successfully',
                'status'=>true
            ],Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);        }
    }

    public function cut(Request $request, $id):JsonResponse
    {
        try {
            $validartor = Validator::make($request->all(),[
                'task_id' =>'required'
            ]);
            if ($validartor->fails()){
                return response()->json([
                    'message'=>$validartor->errors()->first(),
                    'status'=> false
                ],Response::HTTP_BAD_REQUEST);
            }
            $subtask = SubTask::findOrFail($id);
            $task = Task::findOrFail($request->task_id);
            $subtask->task_id = $request->task_id;
            $subtask->save();
            return response()->json([
                'message' =>'subtask moved successfully',
                'status'=>true
            ],Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }
    public function getRunningTask():JsonResponse
    {
        try {
            $subtasks = SubTask::where('subtask_user_id', Auth::user()->id)->where('timer',1)->first();
            return response()->json([
                'subtask' =>$subtasks,
                'status'=>true
            ],Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }


    }

    public function categorysubtasks(Request $request)
    {
        $cat_id = $request->cat_id;
        $id = $request->id;
        $tasks = Task::all();
        if ($request->cat_id) {
            $tasks = Task::where('task_category_id', $request->cat_id)->get();
        }
        if (!$tasks) {
            return response()->json(['error' => 'Tasks  not found']);
        }
        return response()->json([
            'message' => 'Tasks Found ',
            'status' => true ,
            'tasks' => $tasks
        ], Response::HTTP_OK);

    }



    public function assigned_tasks(Request $request)
    {

        $assigned_tasks = SubTask::with('added_by')
            ->whereHas('task', function ($query) {
                $query->whereNotNull('id'); // Exclude subtasks with an empty history
            })

            ->with('task.category')
            ->where(['subtask_added_by' => Auth::user()->id])
            ->orderBy('id','DESC')
            ->get();

        $unmatched_tasks = $assigned_tasks->filter(function ($subtask) {
            return $subtask->subtask_status != 1 || $subtask->tested != 1;
        });

        $matched_tasks = $assigned_tasks->diff($unmatched_tasks);

        $filtered_tasks = $unmatched_tasks->filter(function ($subtask) {
            return !empty($subtask->task);
        });

        $perPage = config('constants.PER_PAGE');
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginated_tasks = new LengthAwarePaginator(
            $filtered_tasks->forPage($page, $perPage),
            $filtered_tasks->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]
        );

        return response()->json([
            'assigned_tasks' => $paginated_tasks,
            'status' => 0,
        ], Response::HTTP_OK);



    }
    public  function changetester(Request $request)
    {
        $data = $request->all() ;
        SubTask::with('added_by')->with('task.category')->where(['id' => $data['subtask_id']])->update(['tester' => $data['user_id']]) ;
        return response()->json([
            'message' =>  'Task Updated Successfuly' ,
            'status' => true  ,
        ] , Response::HTTP_OK) ;

    }
    public  function tested(Request $request)
    {
        $data = $request->all() ;
        SubTask::where(['id' => $data['subtask_id']])->update(['tested' => $data['value']]) ;
        return response()->json([
            'message' =>  'Task Updated Successfuly' ,
            'status' => true  ,
        ] , Response::HTTP_OK) ;

    }

    public function tests(Request $request )
    {

        $tests =  SubTask::where('tester' , Auth::user()->id )
            ->with('added_by')->with('task.category')
            ->where('tested', '!=', 1)
            ->where('subtask_status', '!=', 1)
            ->orWhere(['subtask_added_by'=> Auth::user()->id ])->where('tester' , '!='  ,Auth::user()->id )->where('tested', '!=',1) ->where('subtask_status', '!=', 1)
            ->orderBy('id' , 'DESC')->paginate(config('constants.PER_PAGE')); ;
        return response()->json([
            'tested' => $tests,
            'status' => 0,
        ], Response::HTTP_OK);

    }
    public  function filter_mytest(Request  $request)
    {
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

        if($start_due_date == $end_due_date)
        {
            $start_due_date = $start_due_date.' 00:00:00';
            $end_due_date = $end_due_date.' 23:59:59';
        }
        if(!empty($request->done))
        {
            $done = $request->done ;
        }else
        {
            $done = 0 ;
        }
        if(empty($request->start_due_date) && empty($request->end_due_date)) {
            if (!empty($request->my_test)){
                if ($request->my_test == 1) {
                    if($done == 1 )
                    {
                        $subtasks = SubTask::where(['tester' => auth::user()->id])
                            ->where(['tested' => 1 , 'subtask_status'=> 1])
                            ->with('added_by')
                            ->with('history')
                            ->with('task.category')
                            ->paginate(config('constants.PER_PAGE'));
                    }else
                    {
                        $subtasks = SubTask::where(['tester' => auth::user()->id])
                            ->with('added_by')
                            ->with('history')
                            ->where(function ($query) {
                                $query->where('subtask_status', '!=', 1)
                                    ->orWhere('tested', '!=', 1);
                            })
                            ->with('task.category')
                            ->paginate(config('constants.PER_PAGE'));
                    }

                }
            }
            if (!empty($request->created)) {
                if ($request->created == 1) {
                    if($done == 1 ) {
                        $subtasks = SubTask::where(['subtask_added_by' => auth::user()->id])
                            ->where('tester', '!=', auth::user()->id)
                            ->where(['tested' => 1 , 'subtask_status'=> 1])
                            ->with('added_by')
                            ->with('history')
                            ->with('task.category')
                            ->where('tester', '!=', auth::user()->id)
                            ->paginate(config('constants.PER_PAGE'));
                    }else
                    {
                        $subtasks = SubTask::where(['subtask_added_by' => auth::user()->id])
                            ->where('tester', '!=', auth::user()->id)
                            ->with('added_by')
                            ->with('history')
                            ->with('task.category')
                            ->where('tester', '!=', auth::user()->id)
                            ->where(function ($query) {
                                $query->where('subtask_status', '!=', 1)
                                    ->orWhere('tested', '!=', 1);
                            })
                            ->paginate(config('constants.PER_PAGE'));
                    }
                }
            }
        }

        if(!empty($request->start_due_date) && !empty($request->end_due_date)) {

            if (empty($request->my_test) && empty($request->created)) {
                $subtasks = SubTask::where(['tester' => auth::user()->id])
                    ->with('added_by')->with('history')->with('task.category')
                    ->orWhere(['subtask_added_by' => auth::user()->id])->where('tester', '!=', auth::user()->id)
                    ->whereBetween('assigned_at', [$start_due_date . " 00:00:00", $end_due_date . " 23:59:59"])->paginate(config('constants.PER_PAGE'));
            }

            if (!empty($request->my_test)) {
                if ($request->my_test == 1) {

                    if($done == 1 ) {
                        $subtasks = SubTask::with('added_by')
                            ->where(['tester' => auth::user()->id])
                            ->where(['tested' => 1 , 'subtask_status'=> 1])
                            ->with('history')
                            ->with('task.category')
                            ->whereBetween('created_at', [$start_due_date, $end_due_date])
                            ->paginate(config('constants.PER_PAGE'));
                    }else
                    {
                        $subtasks = SubTask::with('added_by')
                            ->with('history')
                            ->with('task.category')
                            ->whereBetween('created_at', [$start_due_date, $end_due_date])
                            ->where(['tester' => auth::user()->id])
                            ->where(function ($query) {
                                $query->where('subtask_status', '!=', 1)
                                    ->orWhere('tested', '!=', 1);
                            })
                            ->paginate(config('constants.PER_PAGE'));
                    }

                }
            }
            if (!empty($request->created)) {
                if ($request->created == 1) {
                    {
                        if($done == 1 ) {
                            $subtasks = SubTask::with('added_by')
                                ->with('history')
                                ->with('task.category')
                                ->where(['tested' => 1 , 'subtask_status'=> 1])
                                ->whereBetween('created_at', [$start_due_date, $end_due_date])
                                ->where(['subtask_added_by' => auth::user()->id])
                                ->where('tester', '!=', auth::user()->id)
                                ->paginate(config('constants.PER_PAGE'));
                        }else
                        {
                            $subtasks = SubTask::with('added_by')
                                ->with('history')
                                ->with('task.category')
                                ->whereBetween('created_at', [$start_due_date, $end_due_date])
                                ->where(['subtask_added_by' => auth::user()->id])
                                ->where('tester', '!=', auth::user()->id)
                                ->where(function ($query) {
                                    $query->where('subtask_status', '!=', 1)
                                        ->orWhere('tested', '!=', 1);
                                })
                                ->paginate(config('constants.PER_PAGE'));
                        }
                    }
                }
            }
        }
        return response()->json([
            'subtasks' =>  $subtasks ,
            'status' => 1  ,
        ] , Response::HTTP_OK) ;
    }
    public function  filter_assigned(Request $request)
    {
        $data = $request->all();
        $assigned_tasks = '';
        //1- both Completed And Un completed
        if ((!empty($data['status']) && $data['status'] == 'both') && empty($data['test'])) {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id])->paginate(config('constants.PER_PAGE'));
        }
        // 2- un Completed Tasks
        else if ((!empty($data['status']) && (int)$data['status'] == 2) && empty($data['test']))
        {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id ,  'subtask_status'=> 0])->paginate(config('constants.PER_PAGE'));

        }
        // 3- unCompleted Tasks
        else if ((!empty($data['status']) && (int)$data['status'] == 1) && empty($data['test']))
        {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id ,  'subtask_status'=> 1])->paginate(config('constants.PER_PAGE'));

        }

        //4-tested And Un tested
        if ((!empty($data['test']) && $data['test'] == 'both') && empty($data['status'])) {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id])->paginate(config('constants.PER_PAGE'));

        }
        // 5- untested  Tasks
        else if ((!empty($data['test']) && (int)$data['test'] == 2) && empty($data['status']))
        {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id , 'tested'=> 0])->paginate(config('constants.PER_PAGE'));


        }
        // 6- tested Tasks
        else if ((!empty($data['test']) && (int)$data['test'] == 1) && empty($data['status']))
        {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id , 'tested'=> 1])->paginate(config('constants.PER_PAGE'));
        }


        // 7-tested And completed
        else if ((!empty($data['test']) && $data['test'] == 1) && (!empty($data['status']) && $data['status'] == 1)) {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 1 , 'subtask_status' => 1])->paginate(config('constants.PER_PAGE'));

        }
        // 8-untested And uncompleted
        else if ((!empty($data['test']) && $data['test'] == 2) && (!empty($data['status']) && $data['status'] == 2)) {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 0 , 'subtask_status' => 0])->paginate(config('constants.PER_PAGE'));
        }

        // 9 -tested And uncompleted
        else if ((!empty($data['test']) && $data['test'] == 1) && (!empty($data['status']) && $data['status'] == 2)) {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 1 , 'subtask_status' => 0])->paginate(config('constants.PER_PAGE'));

        }
        // 10 -untested And completed
        else if ((!empty($data['test']) && $data['test'] == 2) && (!empty($data['status']) && $data['status'] == 1)) {
            $assigned_tasks = SubTask::with('added_by')->with('task.category')->where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 0 , 'subtask_status' => 1])->paginate(config('constants.PER_PAGE'));
        }

        $status = 0 ;

        return response()->json([
            'assigned_tasks' =>  $assigned_tasks ,
            'status' => 0  ,
        ] , Response::HTTP_OK) ;

    }
    /* New Time  Tracking */
    public function  TimeTrackingChart(Request $request)
    {
        $startDate = now()->subDays(6)->startOfDay(); // Start date for the 7-day period
        $endDate = now()->endOfDay(); // End date (today)

        $taskshistory = SubTask::with(['history' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])
            ->where('subtask_user_id', auth::user()->id)
            ->get()
            ->map(function ($subtask) {
                $dailyTimes = [];

                foreach ($subtask->history as $history) {
                    $date = $history->created_at->toDateString();

                    if (!isset($dailyTimes[$date])) {
                        $dailyTimes[$date] = 0;
                    }

                    $dailyTimes[$date] += $history->Time;
                }

                $subtask->dailyTimes = $dailyTimes;

                return $subtask;
            });

        $response = [];
        $dailyTotals = [];
// Generate the response array with daily data and total time
        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            $formattedDate = $date->toDateString();
            // Initialize
            $dailyTotals[$formattedDate] = [];


            $dailyData = [
                'date' => $formattedDate,
                'totalTime' => '00:00', // Initialize with 00:00 format
            ];
            $seconds = 0 ;
            foreach ($taskshistory as $subtask) {
                if (isset($subtask->dailyTimes[$formattedDate])) {
                    // Add task
                    $seconds +=$subtask->dailyTimes[$formattedDate] ;

                }
            }

            $minutes = floor($seconds / 60);
            $hours = floor($minutes / 60);
            $minutes = $minutes % 60;
            
            $dailyData['totalTime']  = sprintf("%02d:%02d", $hours, $minutes);
            $response[] = [
                'date' => $formattedDate,
                'Time' =>  $dailyData['totalTime']
            ];
        }

        return response()->json([
            'message' => 'Task Day And Its Time ' ,
            'data' => $response
       ]);
    }



}
