<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\User;
use App\Models\Log;
use App\Models\Comment;
use App\Models\Timer;
use App\Models\TaskTeam;
use App\Models\TaskHistory;
use App\Models\Replay;
use DataTables;
use DB;
use Validator;
use Auth;
use DateTime;
use DateInterval;
use Carbon\Carbon ;
use App\Events\NewNotification;
use App\Events\ReplayNotification;
use App\Events\ComentsNotification;


class SubTasksController extends Controller
{

  public function __construct() {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
        $this->user = Auth::user();

        $minutes_to_add = 10;
        $time = new DateTime( Auth::user()->login_at);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $stamp = $time->format('Y-m-d H:i:s');

        Auth::user()->login_at = $stamp;
         Auth::user()->login_status = 1;
        Auth::user()->save();
        return $next($request);
        });


  }
  public function index() {
       $datas = SubTask::where('account_id' , auth()->user()->account_id)->orderBy('subtask_priority' , 'asc')->get();
       return view('admin.subtasks.index',compact('datas'));
   }

   public function copy_subtask(Request $request,$id){
       try {
           $subtask= SubTask::find($id);
           $task_id =Task::find($request->task);
           abort_if(!$task_id,404);
           abort_if(!$subtask,404);
           $replicated= $subtask->replicate();
           $replicated->task_id =$request->task;
           $replicated->save();
           return back()->with(['success'=>' Unteraufgabe geklont']);
       } catch (\Exception $exception) {
            return back()->with(['error'=>$exception->getMessage()]);
       }
   }
    public function cut_subtask(Request $request,$id){
        $subtask= SubTask::find($id);
        $task =Task::find($request->task);
        abort_if(!$task,404);
        abort_if(!$subtask,404);
        $subtask->task_id = $request->task;
        $subtask->save();
        return back()->with(['success'=>' Unteraufgabe verschoben']);
    }


    public function create() {
     $users = User::where('account_id' , auth()->user()->account_id)->get();
     $tasks = Task::where('account_id' , auth()->user()->account_id)->get();
     return view('admin.subtasks.create',compact('users','tasks'));
  }

  public function store(Request $request) {
       // dd($request->all());
      try {
        $validator = Validator::make($request->all(),[
             // 'subtask_title' => 'required|string|max:60',
               'task_id' => 'required',
             // 'subtask_user_id' => 'required',
           //   'subtask_start_date' => 'required',
             // 'subtask_due_date' => 'required',
          ]);

          if ($validator->fails()) {
              return redirect()->route('admin.subtasks.create')->with(array('errors' => $validator->getMessageBag()));
          }
         DB::beginTransaction();
         $data = new SubTask();
         $data->subtask_title = preg_replace('/\s+/', ' ', nl2br($request->subtask_title));
         $data->task_id = $request->task_id;
         $data->subtask_user_id = $request->subtask_user_id;
         $data->subtask_added_by = Auth::user()->id;
         //$data->subtask_start_date = $request->subtask_start_date;
         $data->subtask_due_date = $request->subtask_due_date;
         $data->account_id = auth()->user()->account_id;
         $data->save();
         $log = new Log();
         $log->log_desc = "The User ".Auth::user()->user_name .' Add A New Unteraufgabe ';
         $log->log_user_id = Auth::user()->id;
         $log->log_subtask_id = $data->id;
         $log->account_id = auth()->user()->account_id;
         $log->save();
         DB::commit();
          $log->log_task_id =   $request->task_id;
          $log->user_name = Auth::user()->user_name;
          $log->user_image = Auth::user()->image;
             //real time event
           event(new NewNotification($log));


         // $subtasks =SubTask::where('task_id' , $request->task_id )->get();
         // $data = view('admin.tasks.todos',compact('subtasks'))->render();
         // return response()->json(['options'=>$data]);
         $task = Task::find($request->task_id);
         $data = view('admin.tasks.single_task',compact('task'))->render();
         return response()->json(['options'=>$data]);
        // return redirect()->route('admin.subtasks')->with(['success' => 'Data Added Successfully']);
      }catch(Exception $e) {
          //return redirect()->route('admin.subtasks')->with(['error' => 'Something Wrong Happen']);
      }


  }
  public function edit(Request $request ) {
          $id     = $request->id;
          $data  = SubTask::find($id);
          $users = User::where('account_id' , auth()->user()->account_id)->get();
          $tasks = Task::where('account_id' , auth()->user()->account_id)->get();
          return view('admin.subtasks.edit', ['data' => $data,'id' => $id , 'users' => $users , 'tasks' => $tasks ]);
   }
  public function update(Request $request , $id) {
    try {
      $validator = Validator::make($request->all(),[
            'subtask_title' => 'required|string|max:60',
             'task_id' => 'required',
            'subtask_user_id' => 'required',
            'subtask_start_date' => 'required',
            'subtask_due_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.subtasks.create')->with(array('errors' => $validator->getMessageBag()));
        }
       DB::beginTransaction();
             $data =SubTask::find($id);
             $data->subtask_title = $request->subtask_title;
             $data->task_id = $request->task_id;
             $data->subtask_user_id = $request->subtask_user_id;
             $data->subtask_start_date = $request->subtask_start_date;
             $data->subtask_due_date = $request->subtask_due_date;
             $data->save();
             $log = new Log();
             $log->log_desc = "The User ".Auth::user()->user_name .' Updated The Sub Task ' . $data->subtask_title ;
             $log->log_user_id = Auth::user()->id;
             $log->log_subtask_id = $id;
              $log->account_id = auth()->user()->account_id;
             $log->save();
             DB::commit();
            return redirect()->route('admin.subtasks')->with(['success' => 'Data Updated Successfully']);
          }catch(Exception $e) {
              return redirect()->route('admin.subtasks')->with(['error' => 'Something Wrong Happen']);
          }

 }
 public function delete(Request $request) {
       $id = $request->id;
       $data = SubTask::find($id);
          $tskid = $data->task_id;
       $log = new Log();
       $log->log_desc = Auth::user()->user_name .' hat das Unteraufgabe ' . $data->subtask_title . ' geloscht' ;
       $log->log_user_id = Auth::user()->id;
       $log->log_subtask_id = $id;
         $log->account_id = auth()->user()->account_id;
       $data->delete();
       $log->save();
       $log->log_task_id =    $tskid;
         $log->user_name = Auth::user()->user_name;
         $log->user_image = Auth::user()->image;
  //real time event
            event(new NewNotification($log));
        $task = Task::find($request->task_id);
         $data = view('admin.tasks.single_task',compact('task'))->render();
         return response()->json(['options'=>$data]);


      }

      public function updateStatus(Request $request) {
              $id   = $request->id;
              $data =SubTask::find($id);
              if($data->subtask_status == 0) {
                    $data->subtask_status = 1;
                    $data->subtask_completed_at = \Carbon\Carbon::now()->addHour(2);
                    $log = new Log();
                    $log->log_desc =  Auth::user()->user_name .' hat eine Unteraufgabe als erledigt markiert ';
                    $log->log_user_id = Auth::user()->id;
                    $log->log_subtask_id = $id;
                    $log->account_id = auth()->user()->account_id;

              }else {
                 $data->subtask_status = 0;
                 $data->subtask_completed_at = NULL;
                 $log = new Log();
                 $log->log_desc =  Auth::user()->user_name .' hat eine Unteraufgabe als nicht erledigt markiert ';
                 $log->log_user_id = Auth::user()->id;
                 $log->log_subtask_id = $id;
                 $log->account_id = auth()->user()->account_id;
              }
              $data->save();
              $log->save();
              $log->log_task_id =   $data->task_id;
              $log->user_name = Auth::user()->user_name;
              $log->user_image = Auth::user()->image;
//real time event
             event(new NewNotification($log));
              $task = Task::find($request->task_id);
              $data = view('admin.tasks.single_task',compact('task'))->render();
                  $users = User::where('role','!=',3)->get();
              $data2 = view('admin.tasks.uncompleted_subtasks',compact('task','users'))->render();
              return response()->json(['options'=>$data , 'options2'=>$data2]);
      }

      public  function  taskresponsiple(Request $request)
      {
           $users = User::where('account_id' , auth()->user()->account_id)->get();
           foreach($users as $user)
           {
               echo "<option value='$user->id'>".$user->user_name."</option>" ;
           }
      }

      public function updateFieldd(Request $request) {

        //  dd($request->all());
         // return $request;
          try {
              $subtask  = SubTask::find($request->subtask_id);

              if(!empty($subtask)) {
                  if(!empty($request->desc_val)) {
                      $subtask->subtask_title = $request->desc_val;
                  }

                  if(!empty($request->date_val)) {
                      $subtask->subtask_due_date =date('Y-m-d', strtotime($request->date_val));
                  }
                  if(!empty($request->resp_val)) {

                      $teammember = TaskTeam::where('task_id' , $subtask->task_id)->where('user_id' , $request->resp_val)->first();
                      if(!empty($teammember)) {
                          $subtask->subtask_user_id = $request->resp_val;
                      }else {
                          $team = new TaskTeam();
                          $team->task_id = $subtask->task_id;
                          $team->user_id = $request->resp_val;
                          $team->account_id = auth()->user()->account_id;
                          $team->save();
                          $subtask->subtask_user_id = $request->resp_val;
                      }
                  }

                  $subtask->save();
                  $log = new Log();
                  $log->log_desc =  Auth::user()->user_name .' hat eine Anderungen in Unteraufgabe ' .  $subtask->subtask_title . ' ubernommen';
                  $log->log_user_id = Auth::user()->id;
                  $log->log_subtask_id = $request->subtask_id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->log_task_id =   $subtask->task_id;
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;

                  event(new NewNotification($log));
                  return response()->json(['success'=>'subtask field updated']);
              }
          } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);
          }

      }
      public  function sorting(Request $request)
      {


          $perorityList = $request->all() ;
              foreach($request->list as $key => $subtaksId){

                      $d = SubTask::find($subtaksId);
                      if(!empty($d)) {
                      $d->subtask_priority = $key;

                      $d->save();
              }
    }
      }
      public function storeComment(Request $request) {

          if($request->type == 'image') {
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
                  $data->tags = $request->tags ;
                  $data->save();


                  event(new ComentsNotification($data));

                  $comments = Comment::where('task_id',$request->task_id)->with('user')->orderBy('id' , 'DESC')->get();
                  $data = view('admin.tasks.comments',compact('comments'))->render();
                  return response()->json(['options'=>$data]);
              }catch(Exception $e) {
                  return redirect()->route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
              }
          }else {

                try {
                  $validator = Validator::make($request->all(),[
                         'comment' => 'required',
                         'task_id' => 'required',
                    ]);

                      $task = Task::find($request->task_id);
                 /*  DB::beginTransaction();*/
                         $data =new Comment();
                         $data->comment = $request->comment;
                         $data->tags = $request->tags ;
                         $data->task_id = $request->task_id;
                         $data->comment_added_by = Auth::user()->id;
                         $data->account_id = Auth()->user()->account_id;
                         $data->save();
                         $this->sendCommentNotify($request->tags , 'New Comment' , $request->comment);
                         $newcomment = [
                             'last_comment_id' => $data->id  ,
                             'comment_author' =>  $data->comment_added_by
                          ];
                         $last_comment_id = $data->id  ;

                            $comment_data = [
                                'comment_id' =>   $last_comment_id ,
                                'added_by'  =>    Auth::user()->id ,
                                'task_id'   =>    $request->task_id ,
                                'comment_author'  =>  Auth::user()->first_name ,
                                'user_image' =>  auth::user()->image ,
                            ];

                           event(new ComentsNotification($comment_data));
                            return $newcomment ;

                      }catch(Exception $e) {
                          return redirect()->route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
                      }
              }
    }

    public function updateComment(Request $request) {
         try {
               DB::beginTransaction();
               $data =Comment::find($request->id);
               $data->comment = $request->comment_name;
               $data->save();
               DB::commit();

            }catch(Exception $e) {

            }
    }

    public function deleteComment(Request $request) {
          $id = $request->id;
          $data = Comment::find($id);
          $data->delete();
          $msg = 'Comment Deleted Successfully';
          return response()->json([
                     "status" =>  true,
                     "msg" => $msg
          ],200);
    }
    public function deletereplay(Request $request)
    {
        $id = $request->id;
        $data = Replay::find($id);
        $data->delete();

    }
   public function show_comments(Request $request)
   {

       $comments =  Comment::get() ;
       $notes = [] ;
       foreach($comments as $comment){
           $read_users =  json_decode($comment['readby']) ;
           if(!empty($comment->tags)) {

               $tags = explode(',', $comment->tags);

               if (in_array(Auth()->user()->id, $tags)) {
                   if(!empty($read_users)) {
                       if (in_array(Auth()->user()->id, $read_users)) {
                           $notes[] = $comment;
                       }
                   }
               }
           }
       }

       $data = view('admin.notes.commentviewed',compact('notes'))->render();
       return response()->json(['options'=>$data]);

   }

    public function starttime(Request $request)
    {
        $id = $request->task_id;
        $data = SubTask::find($id);
        $data->timer = 1 ;
        $data->start_time_system = date("Y-m-d H:i:s");  //Time From Server Germania
        $data->save();

    }
    public function storeTime(Request $request) {

     $time = $request->time;
     $id = $request->id;

     $data = SubTask::find($id);
     $data->timer = 0;

     if(!$data->subtask_time){
       $data->subtask_time ='00:00:00' ;
     }
     $data->save();

     //get The diffrence  between now  and  time  on system

        $created = new Carbon($data->start_time_system);
        $now = Carbon::now();
        $difference = ($created->diff($now)) ;
        $hours  =  $difference->h ;
        $minutes = $difference->i ;
        $seconds = $difference->s ;


     $start_time = array_map('intval', explode(':', $data->subtask_time));
     $stop_time = array_map('intval', explode(':', $time));

     /*History Time*/
     $xhours =   $stop_time[0];
     $xminutes=  $stop_time[1];
     $xseconds = $stop_time[2];

   $str_time  = $xhours.':'.$xminutes.':'.$xseconds ;   // '170: 125: 130';
   //convert on seconds
   $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);

   sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

   $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;



      $hours = $start_time[0] +  $hours;
      $minutes= $start_time[1] +  $minutes;
      $seconds =  $start_time[2] +  $seconds;

      $param  = $hours.':'.$minutes.':'.$seconds ;   // '170: 125: 130';


      $hms = array_map('intval', explode(':', $param));
      $hms[1] += floor($hms[2] / 60);
      $hms[2] %= 60;
      $hms[0] += floor($hms[1] / 60);
      $hms[1] %= 60;
      ///dd(implode(': ', $hms));
      if($hms[0] < 10) {
        $hms[0] = '0' . $hms[0];
      }
      if($hms[1] < 10) {
        $hms[1] = '0'. $hms[1];
      }
      if($hms[2] < 10) {
        $hms[2] = '0'. $hms[2];
      }

      $data->subtask_time = implode(': ', $hms);


         $taskshistory = new TaskHistory();
         $taskshistory->task_id = $data->id ;
         $taskshistory->user_id = $data->subtask_user_id ;
         $taskshistory->Time  = $time_seconds ;
         $taskshistory->save() ;
         $data->save();

    }

    public function store_timer(Request $request) {

       $data = $request->all() ;
        $taskdata =  SubTask::where(['id' => $request->task_id , 'subtask_user_id' => $request->userid])->update(['timer_value' => $request->timer_value ]) ;
    }


        public function get_timer(Request $request) {
            $data = $request->all() ;
            $taskdata =  SubTask::where(['subtask_user_id' =>$request->userid , 'timer' => 1])->first() ;
            if(!empty($taskdata)) {
                $created = new Carbon($taskdata->start_time_system);
                $now = Carbon::now();
                $difference = ($created->diff($now));
                $hours = $difference->h;
                $minutes = $difference->i;
                $seconds = $difference->s;
                return response()->json(['taskdata' => $taskdata, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds]);
            }
        }


    //Task History
    public function  task_history(Request $request)
    {
       $taskshistory =  SubTask::with('history')->where('subtask_user_id' ,  auth::user()->id )->get();
       $users = User::get() ;
       $status = 0;
       return view('admin.subtasks.admin_tasks_history')->with(compact('taskshistory','status' , 'users'));
    }
    public function  historydescription(Request $request)
    {
        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
        if (isset($request->start_due_date) && isset($request->end_due_date)) {
            if ($request->start_due_date == $request->end_due_date) {

                $history = TaskHistory::where(['task_id' => $request->task_id])->where(DB::raw('Date(created_at)'), '=', $start_due_date)->get();
            }
            else
            {
                $history = TaskHistory::where(['task_id' => $request->task_id])->whereBetween(DB::raw('Date(created_at)'), [$start_due_date, $end_due_date])->get();
            }
       }
        else {
                $history = TaskHistory::where(['task_id' => $request->task_id])->get();
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

      foreach($history as $data)
      {



             $start_time  = timeToSeconds( date_format($data->created_at ,'h:i:s') );
             $startonseconds  =  $start_time - $data->Time ;
             $hours_start = floor($startonseconds / 3600);
             $mins_start = floor($startonseconds / 60 % 60);
             $secs_start = floor($startonseconds % 60);
             $startformat  = sprintf('%02d:%02d:%02d', $hours_start, $mins_start, $secs_start);


           $dates[] = $data->id ;
           $dates[] =  $startformat  ;
           $dates[] = date_format( $data->created_at ,'h:i:s')  ;

           $hours = floor($data->Time / 3600);
           $mins = floor($data->Time / 60 % 60);
           $secs = floor($data->Time % 60);
           $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);


           $dates[] =  $timeFormat  ;

          $dates[] = date_format( $data->created_at ,'d.m.Y');

      }

     //  dd(count($dates));

      for($i = 0 ; $i <count($dates) ; $i+=5) {
          echo '<tr>' ;
           for($j = $i ; $j<$i+5; $j++) {

               echo "<td>$dates[$j]</td>" ;
           }
          echo '</tr>' ;
      }


    }
    //Disply all  Assigned  Tasks
    public function assigned_tasks(Request $request)
    {
       $assigned_tasks =  SubTask::where(['subtask_added_by'=> Auth::user()->id])->get() ;
       $status = 0 ;
       return view('admin.subtasks.assigned_tasks')->with(compact('assigned_tasks' , 'status')) ;
    }
    public  function changetester(Request $request)
    {
         $data = $request->all() ;
         SubTask::where(['id' => $data['subtask_id']])->update(['tester' => $data['user_id']]) ;

    }
    public  function tested(Request $request)
    {
        $data = $request->all() ;
        SubTask::where(['id' => $data['subtask_id']])->update(['tested' => $data['value']]) ;

    }
    public function tests(Request $request )
    {
        $tests =  SubTask::where(['tester'=> Auth::user()->id])->orderBy('id' , 'DESC')->get() ;
        $status = 0 ;
        return view('admin.subtasks.tests')->with(compact('tests'  ,  'status')) ;
    }
    public function  filter_assigned(Request $request)
    {
        $data = $request->all();
        $assigned_tasks = '';
        //1- both Completed And Un completed
        if ((!empty($data['status']) && $data['status'] == 'both') && empty($data['test'])) {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id])->get();
        }
        // 2- un Completed Tasks
        else if ((!empty($data['status']) && (int)$data['status'] == 2) && empty($data['test']))
        {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id ,  'subtask_status'=> 0])->get();

        }
         // 3- unCompleted Tasks
        else if ((!empty($data['status']) && (int)$data['status'] == 1) && empty($data['test']))
        {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id ,  'subtask_status'=> 1])->get();

        }

        //4-tested And Un tested
        if ((!empty($data['test']) && $data['test'] == 'both') && empty($data['status'])) {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id])->get();

        }
        // 5- untested  Tasks
        else if ((!empty($data['test']) && (int)$data['test'] == 2) && empty($data['status']))
        {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id , 'tested'=> 0])->get();


        }
        // 6- tested Tasks
        else if ((!empty($data['test']) && (int)$data['test'] == 1) && empty($data['status']))
        {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id , 'tested'=> 1])->get();
        }


        // 7-tested And completed
        else if ((!empty($data['test']) && $data['test'] == 1) && (!empty($data['status']) && $data['status'] == 1)) {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 1 , 'subtask_status' => 1])->get();

        }
        // 8-untested And uncompleted
        else if ((!empty($data['test']) && $data['test'] == 2) && (!empty($data['status']) && $data['status'] == 2)) {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 0 , 'subtask_status' => 0])->get();
        }

        // 9 -tested And uncompleted
        else if ((!empty($data['test']) && $data['test'] == 1) && (!empty($data['status']) && $data['status'] == 2)) {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 1 , 'subtask_status' => 0])->get();

        }
        // 10 -untested And completed
        else if ((!empty($data['test']) && $data['test'] == 2) && (!empty($data['status']) && $data['status'] == 1)) {
            $assigned_tasks = SubTask::where(['subtask_added_by' => Auth::user()->id ,  'tested'=> 0 , 'subtask_status' => 1])->get();
        }

        $status = 0 ;
         $tested_tasks  =  view('admin.subtasks.filter_assigntasks',compact('assigned_tasks','status'))->render() ;
         return response()->json(['options'=> $tested_tasks]) ;
    }

    /*Store Replay of Comments */
    public function storereplay(Request $request )
    {

            $data = $request->all() ;
            $replay =  new Replay() ;

            $replay->comment_id = $data['comment_id'] ;
            $replay->replay     =     $data['replay_comment'];
            $replay->added_by   =   $data['addedby'];
            $replay->added_by_id   =  auth::user()->id;
            $replay->task_id   = $data['task_id'];
            $replay->tags   =    $data['tags'];
            $replay->comment_author   = $data['comment_author'];


            $replay->save() ;

            $replays = Replay::where('comment_id' , $data['comment_id'] )->get() ;
            $count_replays =  $replays->count() ;
            //Real  Time Notfation Replaying

            $replay_data = [
                'comment_id' =>   $data['addedby'] ,
                'replay_id'   =>  $data['replay_comment'] ,
                'added_by'  => $data['addedby'] ,
                'task_id'   =>  $data['task_id'] ,
                'comment_author'  => $data['comment_author'] ,
                'user_image' =>  auth::user()->image ,
                 'comment_date' => date("d.m.Y", strtotime(Carbon::now())),
                 'comment_time' => date("d.m.Y", strtotime(Carbon::now()))
            ];
        //real time event
           if($data['addedby'] != auth::user()->id) {
               event(new ReplayNotification ($replay_data));
           }
            return $count_replays ;


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
        echo $response;
    }

}
