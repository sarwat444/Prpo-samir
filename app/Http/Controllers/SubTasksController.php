<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\User;
use App\Models\Log;
use App\Models\Comment;
use App\Models\Timer;
use App\Models\TaskTeam;
use App\Models\TaskHistory;
use DataTables;
use DB;
use Validator;
use Auth;
use DateTime;
use DateInterval;
use App\Events\NewNotification;
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
         $data->subtask_title = $request->subtask_title;
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
            //   dd($id);
              $data =SubTask::find($id);
              // dd($data);
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
           $subtask  = SubTask::find($request->subtask_id);

           if(!empty($subtask)) {
             if(!empty($request->desc_val)) {
                 $subtask->subtask_title = $request->desc_val;
             }

             if(!empty($request->date_val)) {
                 $subtask->subtask_due_date =     date('Y-m-d', strtotime($request->date_val));
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
      //real time event
                event(new NewNotification($log));
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



                  $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' het ein Kommentar eingefugt';
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $request->task_id;
                  $log->save();
                  DB::commit();
                  $log->log_task_id =   $request->task_id;
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                  //real time event
                  event(new NewNotification($log));
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
                   DB::beginTransaction();
                         $data =new Comment();
                         $data->comment = $request->comment;
                         $data->task_id = $request->task_id;
                          $data->comment_added_by = Auth::user()->id;
                         $data->account_id = auth()->user()->account_id;
                         $data->tags = $request->tags ;

                         $data->save();



                        $log = new Log();
                         $log->log_desc = Auth::user()->user_name .' het ein Kommentar eingefugt';
                         $log->log_user_id = Auth::user()->id;
                          $log->log_task_id = $request->task_id;
                          $log->account_id = auth()->user()->account_id;
                           $log->save();
                           DB::commit();
                          $log->log_task_id =   $request->task_id;
                           $log->user_name = Auth::user()->user_name;
                           $log->user_image = Auth::user()->image;
                 //real time event
                           event(new NewNotification($log));
                          $comments = Comment::where('task_id',$request->task_id)->with('user')->orderBy('id' , 'DESC')->get();
                          $data = view('admin.tasks.comments',compact('comments'))->render();
                          return response()->json(['options'=>$data]);
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

    public function storeTime(Request $request) {

     $time = $request->time;

      $id = $request->id;
     $data = SubTask::find($id);
     if(!$data->subtask_time){
       $data->subtask_time ='0:0:0' ;
     }
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



      $hours = $start_time[0] +  $stop_time[0];
      $minutes= $start_time[1] +  $stop_time[1];
      $seconds =  $start_time[2] +  $stop_time[2];

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
       $taskdata =  Timer::where(['task_id' => $request->task_id , 'timer_user' => $request->userid])->first() ;
       if(empty($taskdata)){
           $timer  = new  Timer() ;
           $timer->timer_value  = $request->timer_value ;
           $timer->timer_user  = $request->userid ;
           $timer->task_id  = $request->task_id ;
           $timer->save() ;
       }else
       {
           Timer::where(['task_id' => $request->task_id , 'timer_user' => $request->userid])->update(['timer_value' =>$request->timer_value]) ;
       }
    }
        public function get_timer(Request $request) {
            $data = $request->all() ;
            $taskdata =  Timer::where(['timer_user' => $request->userid])->first() ;
             return response()->json($taskdata) ;
        }


    //Task History
    public function  task_history(Request $request)
    {
       $taskshistory =  SubTask::with('history')->get();
       $users = User::get() ;
       $status = 0;
       return view('admin.subtasks.admin_tasks_history')->with(compact('taskshistory','status' , 'users'));
    }
    public function  historydescription(Request $request)
    {
      $history = TaskHistory::where(['task_id' => $request->task_id])->get() ;
      $timeonsecondes = 0 ;
      foreach($history as $data)
      {

           $dates[] = $data->id ;
           $dates[] = date($data->created_at);
           $hours = floor($data->Time / 3600);
           $mins = floor($data->Time / 60 % 60);
           $secs = floor($data->Time % 60);
           $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
           $dates[] =  $timeFormat  ;
      }

     //  dd(count($dates));

      for($i = 0 ; $i <count($dates) ; $i+=3 ) {
          echo '<tr>' ;
           for($j = $i ; $j<$i+3; $j++) {

               echo "<td>$dates[$j]</td>" ;
           }
          echo '</tr>' ;
      }


    }

}
