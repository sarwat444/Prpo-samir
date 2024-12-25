<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\User;
use App\Models\TaskTeam;
use App\Models\TaskGuest;
use App\Models\Category;
use App\Models\Log;
use DataTables;
use DB;
use Validator;
use Auth;
use DateTime;
use DateInterval;
use App\Events\NewNotification;
use Session;
use App\Models\Tag;
use App\Models\TaskTag;

class TasksController extends Controller
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
       $datas = Task::where('account_id' , auth()->user()->account_id)->orderBy('task_priority')->get();
       return view('admin.tasks.index',compact('datas'));
   }

   public function create() {
     $users = User::where('account_id' , auth()->user()->account_id)->get();
     $categories = Category::where('account_id' , auth()->user()->account_id)->get();
     return view('admin.tasks.create',compact('users','categories'));
  }

  public function store(Request $request) {
          //  dd($request->all());
      try {
        $validator = Validator::make($request->all(),[
              'task_title' => 'required|string|max:60',
              'task_desc' => 'required',
              'task_category_id' => 'required',
              'task_responsible' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
        }
         DB::beginTransaction();
         $data = new Task();
         $data->task_title = $request->task_title;
         $data->task_desc = $request->task_desc;
         $data->task_category_id = $request->task_category_id;
         $data->task_category_id_two = $request->task_category_id_two;
         $data->task_added_by = Auth::user()->id;
         $data->task_responsible = $request->task_responsible;
         $data->task_start_date = $request->task_start_date;
         $data->task_due_date =  date('Y-m-d', strtotime($request->task_due_date));
         $data->account_id = auth()->user()->account_id;
         $data->save();
         $inserted_id   =    $data->id;
         $data->task_priority = $inserted_id;
         $data->save();
         if(!empty($request->teams_id)) {
                     $interest_array = $request->teams_id;
                     $array_len = count($interest_array);
                     for ($i = 0; $i < $array_len; $i++) {

                               if($interest_array[$i] == Auth::user()->id || $interest_array[$i] == $request->task_responsible){
                                  continue;
                               }else {
                               $dta = new TaskTeam();
                               $dta->user_id = $interest_array[$i];
                               $dta->task_id = $inserted_id;
                               $dta->account_id = auth()->user()->account_id;
                               $dta->save();
                             }
                       }
          }

          if(!empty($request->guests_id)) {
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

        if(!empty($request->tags_id)) {
                $interest_array = $request->tags_id;
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {

                          $tag = Tag::where('id', $interest_array[$i])->first();
                          if(!empty($tag) && !empty($request->task_category_id)) {
                               $tag1 = Tag::where('tag_name', $tag->tag_name)->where('cat_id' , $request->task_category_id)->first();
                                //  dd($tag1);
                               if(empty($tag1)) {
                                   $t1 = new Tag();
                                   $t1->tag_name= $tag->tag_name;
                                   $t1->cat_id = $request->task_category_id;
                                   $t1->account_id = auth()->user()->account_id;
                                   $t1->save();
                               }

                               $tag2 = Tag::where('tag_name', $tag->tag_name)->where('cat_id' , $request->task_category_id_two)->first();
                               if(empty($tag2) && !empty($request->task_category_id_two)) {
                                   $t2 = new Tag();
                                   $t2->tag_name= $tag->tag_name;
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
          $log->log_desc = Auth::user()->user_name .' hat ein Post-it erstellt';
          $log->log_user_id = Auth::user()->id;
          $log->log_task_id = $data->id;
          $log->account_id = auth()->user()->account_id;
          $log->save();
          DB::commit();
          $log->user_name = Auth::user()->user_name;
          $log->user_image = Auth::user()->image;
        //real time event
          event(new NewNotification($log));
           //return redirect()->route('admin.dashboard')->with(['success' => 'Data Added Successfully']);
         if(!empty(session()->get('catt_id'))&& empty(session()->get('tagg_id'))) {
            return redirect()->route('admin.cat.tasks', ['cat_id' => session()->get('catt_id'), 'status' => 0])->with(['success' => 'Data Added Successfully']);
         }else if(!empty(session()->get('catt_id')) && !empty(session()->get('tagg_id'))) {
               return redirect()->route('admin.cat.tag.tasks',['cat_id' => session()->get('catt_id') , 'tag_id' => session()->get('tagg_id'), 'status' => 0])->with(['success' => 'Data Added Successfully']);
         }else {
            return redirect()->route('admin.dashboard')->with(['success' => 'Data Added Successfully']);
         }
      }catch(Exception $e) {
          return redirect()->route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
      }


  }
  public function edit(Request $request ) {
          $id     = $request->id;
          $data  = Task::find($id);
          $users = User::where('account_id' , auth()->user()->account_id)->get();
          $categories = Category::where('account_id' , auth()->user()->account_id)->get();
          return view('admin.tasks.edit', ['data' => $data,'id' => $id , 'users' => $users , 'categories' => $categories ]);
   }
  public function update(Request $request , $id) {
    try {
      $validator = Validator::make($request->all(),[
            'task_title' => 'required|string|max:60',
            'task_desc' => 'required',
            'task_category_id' => 'required',
            'task_responsible' => 'required',
           // 'task_start_date' => 'required',
            //'task_due_date' => 'required',

      ]);

        // if ($validator->fails()) {
        //     return redirect()->route('admin.tasks.create')->with(array('errors' => $validator->getMessageBag()));
        // }
       DB::beginTransaction();
             $data =Task::find($id);
             $data->task_title = $request->task_title;
             $data->task_desc = $request->task_desc;
             $data->task_category_id = $request->task_category_id;
             $data->task_responsible = $request->task_responsible;
           //  $data->task_start_date = $request->task_start_date;
             $data->task_due_date =  date('Y-m-d', strtotime($request->task_due_date)); //$request->task_due_date;

             $data->save();
             if(!empty($request->teams_id)) {

                TaskTeam::where('task_id',$id)->delete();
               $interest_array = $request->teams_id;

               $array_len = count($interest_array);
              for ($i = 0; $i < $array_len; $i++) {

                if($interest_array[$i] == Auth::user()->id || $interest_array[$i] == $request->task_responsible){
                   continue;
                }else {
                       $pres = TaskTeam::where('task_id',$id)->where('user_id',$interest_array[$i])->first();

                        if(!empty($pres)) {
                          continue;
                        }else {
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
              $log->log_desc = "The User ".Auth::user()->user_name .' Updated The Task ' . $data->task_title ;
              $log->log_user_id = Auth::user()->id;
              $log->log_task_id = $id;
              $log->account_id = auth()->user()->account_id;
              $log->save();
             DB::commit();
            return redirect()->route('admin.dashboard')->with(['success' => 'Data Updated Successfully']);
          }catch(Exception $e) {
              return redirect()->route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
          }

 }
 public function delete(Request $request) {
       $id = $request->task_id;
      // dd($id);
       $data = Task::find($id);
       $data->task_status = 2;
       $data->save();
       $log = new Log();
       $log->log_desc = Auth::user()->user_name .' Deleted The Task ' . $data->task_title ;
       $log->log_user_id = Auth::user()->id;
       $log->log_task_id = $id;
       $log->account_id = auth()->user()->account_id;
       $log->save();
       $log->user_name = Auth::user()->user_name;
       $log->user_image = Auth::user()->image;
     //real time event
       event(new NewNotification($log));

       $msg = 'Data Deleted Successfully';
       return response()->json([
                  "status" =>  true,
                  "msg" => $msg
                  ],200);
    }


     public function undelete(Request $request) {
       $id = $request->task_id;
     // dd($id);
       $data = Task::find($id);
       $data->task_status = 0;
       $data->save();
       $log = new Log();
       $log->log_desc = Auth::user()->user_name .' Restore The Task ' . $data->task_title ;
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
                  "status" =>  true,
                  "msg" => $msg
                  ],200);
    }


    public function markComplete(Request $request) {
       $id = $request->task_id;
      // dd($id);
       $data = Task::find($id);
       $data->task_status = 1;
       $data->save();
       $log = new Log();
       $log->log_desc = Auth::user()->user_name .'Mark The Task ' . $data->task_title .'Completed';
       $log->log_user_id = Auth::user()->id;
       $log->log_task_id = $id;
       $log->account_id = auth()->user()->account_id;
       $log->save();
       $log->user_name = Auth::user()->user_name;
       $log->user_image = Auth::user()->image;
     //real time event
       event(new NewNotification($log));
       $msg = 'Data Completed Successfully';
       return response()->json([
                  "status" =>  true,
                  "msg" => $msg
                  ],200);
    }

     public function unmarkComplete(Request $request) {
       $id = $request->task_id;
      // dd($id);
       $data = Task::find($id);
       $data->task_status = 0;
       $data->save();
       $log = new Log();
       $log->log_desc = Auth::user()->user_name .'Mark The Task ' . $data->task_title .'UnCompleted';
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
                  "status" =>  true,
                  "msg" => $msg
                  ],200);
    }

  public function updateStatus($id) {
          $data =Task::find($id);
          if($data->task_status == 0) {
                $data->task_status = 1;
                $log = new Log();
                $log->log_desc = Auth::user()->user_name .' hat ein Post-it' . $data->task_title . ' erledigt Markiert';
                $log->log_user_id = Auth::user()->id;
                $log->log_task_id = $id;
                $log->account_id = auth()->user()->account_id;
          }else {
             $data->task_status = 0;
             $log = new Log();
             $log->log_desc = Auth::user()->user_name .' hat ein Post-it' . $data->task_title . ' nicht erledigt Markiert';
             $log->log_user_id = Auth::user()->id;
             $log->log_task_id = $id;
             $log->account_id = auth()->user()->account_id;
          }
          $data->save();
          $log->user_name = Auth::user()->user_name;
          $log->user_image = Auth::user()->image;
        //real time event
          event(new NewNotification($log));
          $log->save();
  }

    public function showTaskData(Request $request) {
                $id     = $request->id;


                  $task =Task::find($id);
                  $subtasks =SubTask::where('task_id' , $id)->get();
                  $teamids = TaskTeam::where('task_id' , $id)->pluck('user_id');
                  $teams   =  User::whereIn('id',$teamids)->get();
                  $users = User::where('account_id' , auth()->user()->account_id)->where('role','!=',3)->get();

                  $users3 = User::where('account_id' , auth()->user()->account_id)->where(['role','!='=> 3])->get();

                  $cats = Category::where('account_id' , auth()->user()->account_id)->get();
                  $tags = Tag::where('account_id' , auth()->user()->account_id)->distinct('tag_name')->get('tag_name');
                     $users2 = User::where('account_id' , auth()->user()->account_id)->where('role',3)->get();
               if(count($subtasks) > 0) {
                $last_subtask_id = SubTask::where('account_id' , auth()->user()->account_id)->latest()->first()->id;
              }
                if(empty($last_subtask_id)) {
                     $last_subtask_id = 0;
                }

                if($request->type == '1') {
                return view('admin.tasks.popup', ['task' => $task,'users' => $users,'users2' => $users2,'teams' => $teams ,'subtasks' => $subtasks ,'cats' => $cats , 'id' => $id , 'last_subtask_id' => $last_subtask_id , 'tags' => $tags , 'users3' => $users3 ]);
              }else {
                  return view('admin.tasks.popup2', ['task' => $task,'users' => $users,'users2' => $users2,'teams' => $teams ,'subtasks' => $subtasks ,'cats' => $cats , 'id' => $id , 'last_subtask_id' => $last_subtask_id , 'tags' => $tags , 'users3' => $users3]);
              }

    }

      // getCreateView

       public function getCreateView(Request $request) {
                $type     = $request->type;
                $users = User::where('account_id' , auth()->user()->account_id)->where('role','!=',3)->get();
                $users2 = User::where('account_id' , auth()->user()->account_id)->where('role',3)->get();
                $categories = Category::where('account_id' , auth()->user()->account_id)->get();
                $tags = Tag::where('account_id' , auth()->user()->account_id)->distinct('tag_name')->get('tag_name');
              //  dd($tags);
                return view('admin.tasks.'.$type ,  ['users' => $users,'users2' => $users2,'categories' => $categories, 'tags' => $tags]);
     }


     //set perority

     public  function sorting(Request $request)
     {


         $perorityList = $request->all() ;

         if($request->isMethod('POST')){
             foreach($request->list as $key => $taksId){
                    $d = Task::find($taksId);

                     if(!empty($d)) {
                     $d->task_priority = $key;

                     $d->save();

                 }


             }



         }
     }

    public function updateTaskfield(Request $request) {
         //  dd($request->all());
            DB::beginTransaction();

            $id = $request->task_id;
            $data =Task::find($id);

            $cat_id = $data->task_category_id;

            if($request->field_name == 'teams_id') {
              //   dd($request->field_val);
              if(!empty($request->field_val)) {
                    TaskTeam::where('task_id',$id)->delete();
                  $interest_array = $request->field_val;
                  $array_len = count($interest_array);
              for ($i = 0; $i < $array_len; $i++) {

                 if($interest_array[$i] == Auth::user()->id || $interest_array[$i] == $data->task_responsible){
                       continue;
                  }else {
                          $pres = TaskTeam::where('task_id',$id)->where('user_id',$interest_array[$i])->first();
                        if(!empty($pres)) {
                          continue;
                        }else {
                         $dta = new TaskTeam();

                          $dta->user_id = $interest_array[$i];
                          $dta->task_id = $id;
                          $dta->account_id = auth()->user()->account_id;
                          $dta->save();
                        }
                  }

                }

                  $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' hat Anderungen in Post-it ' . $data->task_title . " ubernommen" ;
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                //real time event
                  event(new NewNotification($log));

             }else {
                    TaskTeam::where('task_id',$id)->delete();
                      $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' hat Anderungen in Post-it ' . $data->task_title . " ubernommen" ;
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                //real time event
                  event(new NewNotification($log));
             }



            }else if($request->field_name == 'guests_id'){

                  if(!empty($request->field_val)) {
                    TaskGuest::where('task_id',$id)->delete();
                  $interest_array = $request->field_val;
                  $array_len = count($interest_array);
              for ($i = 0; $i < $array_len; $i++) {


                          $pres = TaskGuest::where('task_id',$id)->where('user_id',$interest_array[$i])->first();
                        if(!empty($pres)) {
                          continue;
                        }else {
                         $dta = new TaskGuest();

                          $dta->user_id = $interest_array[$i];
                          $dta->task_id = $id;
                          $dta->account_id = auth()->user()->account_id;
                          $dta->save();
                        }
            }



                  $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' hat Anderungen in Post-it ' . $data->task_title . " Besucher" ;
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                //real time event
                  event(new NewNotification($log));

             }else {
                    TaskGuest::where('task_id',$id)->delete();
                      $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' hat Anderungen in Post-it ' . $data->task_title . " Besucher" ;
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                //real time event
                  event(new NewNotification($log));
             }


           }else if($request->field_name == 'tags_id'){

                  if(!empty($request->field_val)) {
                    TaskTag::where('task_id',$id)->delete();
                  $interest_array = $request->field_val;
                  $array_len = count($interest_array);
              for ($i = 0; $i < $array_len; $i++) {

                $tag = Tag::where('id', $interest_array[$i])->first();
                if(!empty($tag)) {
                     $tag1 = Tag::where('tag_name', $tag->tag_name)->where('cat_id' , $data->task_category_id)->first();
                     if(empty($tag1) && !empty($data->task_category_id)) {
                         $t1 = new Tag();
                         $t1->tag_name= $tag->tag_name;
                         $t1->cat_id = $data->task_category_id;
                         $t1->account_id = auth()->user()->account_id;
                         $t1->save();
                     }

                     $tag2 = Tag::where('tag_name', $tag->tag_name)->where('cat_id' , $data->task_category_id_two)->first();
                     if(empty($tag2) && !empty($data->task_category_id_two))  {
                         $t2 = new Tag();
                         $t2->tag_name= $tag->tag_name;
                         $t2->cat_id = $data->task_category_id_two;
                         $t2->account_id = auth()->user()->account_id;
                         $t2->save();
                     }
                }

                          $pres = TaskTag::where('task_id',$id)->where('tag_id',$interest_array[$i])->first();
                        if(!empty($pres)) {
                          continue;
                        }else {
                         $dta = new TaskTag();

                          $dta->tag_id = $interest_array[$i];
                          $dta->task_id = $id;
                          $dta->account_id = auth()->user()->account_id;
                          $dta->save();
                        }
            }



                  $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' hat Anderungen in Post-it ' . $data->task_title . " Schild" ;
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                //real time event
                  event(new NewNotification($log));

             }else {
                    TaskTag::where('task_id',$id)->delete();
                      $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' hat Anderungen in Post-it ' . $data->task_title . " Schild" ;
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                //real time event
                  event(new NewNotification($log));
             }


            }else {


           // date('Y-m-d', strtotime($request->task_due_date));


                $field_name = $request->field_name;

                if($field_name == 'task_due_date' ) {
                       $data->$field_name =  date('Y-m-d', strtotime($request->field_val));
                }else {
                $data->$field_name = $request->field_val;
                }

                $data->save();

                  $log = new Log();
                  $log->log_desc = Auth::user()->user_name .' hat Anderungen in Post-it ' . $data->task_title . " ubernommen" ;
                  $log->log_user_id = Auth::user()->id;
                  $log->log_task_id = $id;
                  $log->account_id = auth()->user()->account_id;
                  $log->save();
                  $log->user_name = Auth::user()->user_name;
                  $log->user_image = Auth::user()->image;
                //real time event
                  event(new NewNotification($log));
            }


            DB::commit();

             $task = Task::find($id);
             $data = view('admin.tasks.single_task',compact('task'))->render();

           if($request->field_name == 'task_category_id'  && $request->field_val !=  $cat_id) {
                 return response()->json(['options'=> 'no' ,'options2' => $data]);
           }else {
                 return response()->json(['options'=>$data]);
           }



    }

    public function usertasks(Request $request )
    {

        $status = 0 ;

        $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',0)->get();
        // if(Auth::user()->role == 2 ){
        //     return view('admin.tasks.mytasks')->with(compact('user_subtasks','status')) ;
        // }
        // else
        // {
            $users = User::where('account_id' , auth()->user()->account_id)->get();
            return view('admin.tasks.admintasks')->with(compact('user_subtasks','users','status')) ;
        //}
    }

     public function filterUserSubtasks(Request $request )
    {
          // dd($request->all());
         $users = User::where('account_id' , auth()->user()->account_id)->get();
         $gender = $request->gender;
         if(empty($gender)) {
           $gender = "list";
         }
        $status = 0 ;
        if(Auth::user()->role == 2 ){

                $subtask_status2 = $request->subtask_status2;
                $subtask_user_id =  Auth::user()->id;

                if($request->type == "status2_filter") {
                  //   $subtask_status = $request->subtask_status;
                  $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                  $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                  if(empty($request->start_due_date)) {
                     $start_due_date = null;
                  }
                  if(empty($request->end_due_date)) {
                       $end_due_date = null;
                  }

                  if(empty($request->end_due_date) && empty($request->start_due_date)) {
                       $end_due_date = null;
                        $start_due_date = null;
                  }


                  if(isset($request->subtask_status)) {
                  $subtask_status = $request->subtask_status;
                }else {
                    $subtask_status = null;
                }

                    $subtask_user_id = $request->subtask_user_id;
                      // dd($request->all());
                      if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                          if($subtask_status == 2) {
                             $subtask_status = 0;
                          }

                          if($subtask_user_id == "all"){

                            if($subtask_status2 == 3) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                            }else if($subtask_status2 == 4) {
                                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                            }else if($subtask_status2 == 5) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                            }else {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                              }
                         }else {

                           if($subtask_status2 == 3) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                           }else if($subtask_status2 == 4) {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                           }else if($subtask_status2 == 5) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                           }else {

                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                            }
                         }
                      }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                        if($subtask_user_id == "all"){
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }else {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                         }
                      }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                          if($subtask_status == 2) {
                             $subtask_status = 0;
                          }

                          if($subtask_status2 == 3) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                          }else if($subtask_status2 == 4) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }else if($subtask_status2 == 5) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                          }else {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }
                      }else if(!empty($end_due_date) && !empty($start_due_date)) {


                        if($subtask_status2 == 3) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 4) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 5) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        }else {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }


                      }

                      //dd($user_subtasks);
                      $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                       return response()->json(['options'=>$data]);

               }



                // End status2 filter

          if($request->type == "date_filter") {

             //  dd('heeeeeeeeel');
                // $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                // $end_due_date = date('Y-m-d', strtotime($request->end_due_date));

                $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                if(empty($request->start_due_date)) {
                   $start_due_date = null;
                }
                if(empty($request->end_due_date)) {
                     $end_due_date = null;
                }

                if(empty($request->end_due_date) && empty($request->start_due_date)) {
                      $end_due_date = null;
                      $start_due_date = null;
                }

                $subtask_user_id = $request->subtask_user_id;
                if(isset($request->subtask_status)) {
                $subtask_status = $request->subtask_status;
              }else {
                  $subtask_status = null;
              }
                $subtask_status2 = $request->subtask_status2;

                    if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }
                        if($subtask_user_id == "all"){
                          if($subtask_status2 == 3) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                          }else if($subtask_status2 == 4) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }else if($subtask_status2 == 5) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                          }else {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }
                       }else {
                         if($subtask_status2 == 3) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 4) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 5) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                         }else {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }
                       }
                    }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                      if($subtask_user_id == "all"){
                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }else {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }
                    }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }
                        if($subtask_status2 == 3) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 4) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 5) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        }else {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }
                    } else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                      if($subtask_status == 2) {
                         $subtask_status = 0;
                      }
                      if($subtask_user_id == "all"){
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                       }else {
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->where('subtask_status',$subtask_status)->get();
                        }
                    }else if(!empty($subtask_user_id)) {

                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();

                    }else if(!empty($subtask_status)) {
                      if($subtask_status == 2) {
                         $subtask_status = 0;
                      }
                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->get();

                    } else {

                             $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
            //  dd($start_due_date);
                 $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                 return response()->json(['options'=>$data]);
          }


           if($request->type == "status_filter") {
             //   $subtask_status = $request->subtask_status;

             $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
             $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
             if(empty($request->start_due_date)) {
                $start_due_date = null;
             }
             if(empty($request->end_due_date)) {
                  $end_due_date = null;
             }

             if(empty($request->end_due_date) && empty($request->start_due_date)) {
                  $end_due_date = null;
                   $start_due_date = null;
             }


             if(isset($request->subtask_status)) {
             $subtask_status = $request->subtask_status;
           }else {
               $subtask_status = null;
           }

               $subtask_user_id = $request->subtask_user_id;
                 // dd($request->all());
                 if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }

                     if($subtask_user_id == "all"){

                       if($subtask_status2 == 3) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                       }else if($subtask_status2 == 4) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }else if($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                       }else {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                         }
                    }else {

                      if($subtask_status2 == 3) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                      }else if($subtask_status2 == 4) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                      }else if($subtask_status2 == 5) {
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                      }else {

                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                       }
                    }
                 }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                   if($subtask_user_id == "all"){
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                  }else {
                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                 }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }

                     if($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                     }else if($subtask_status2 == 4) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }else if($subtask_status2 == 5) {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                     }else {
                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }
                 }else if(!empty($end_due_date) && !empty($start_due_date)) {

                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                 }else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                   if($subtask_status == 2) {
                      $subtask_status = 0;
                   }
                   if($subtask_user_id == "all"){
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                  }else {
                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->where('subtask_status',$subtask_status)->get();
                   }
                 }else if(!empty($subtask_user_id)) {

                   if($subtask_user_id == "all"){
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->get();
                  }else {
                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();
                   }
                 } else {
                         if($subtask_status == 2) {
                            $subtask_status = 0;
                         }

                           $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                 }
                 $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                 return response()->json(['options'=>$data]);

          }

          if($request->type == "user_filter") {

            //   $subtask_user_id = $request->subtask_user_id;
        // dd( $subtask_user_id);
             $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
             $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
             if(empty($request->start_due_date)) {
                $start_due_date = null;
             }
             if(empty($request->end_due_date)) {
                  $end_due_date = null;
             }

             if(empty($request->end_due_date) && empty($request->start_due_date)) {
                  $end_due_date = null;
                   $start_due_date = null;
             }

             $subtask_user_id = $request->subtask_user_id;
             if(isset($request->subtask_status)) {
             $subtask_status = $request->subtask_status;
           }else {
               $subtask_status = null;
           }

                 if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }
                     if($subtask_user_id == "all"){

                               if($subtask_status2 == 3) {
                                      $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                               }else if($subtask_status2 == 4) {
                                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                               }else if($subtask_status2 == 5) {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                               }else {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                               }
                    }else {
                      if($subtask_status2 == 3) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                      }else if($subtask_status2 == 4) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                      }else if($subtask_status2 == 5) {
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                      }else {

                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                        }
                    }
                 }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                   if($subtask_user_id == "all"){
                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                  }else {
                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                   }
                 }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }

                     if($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                     }else if($subtask_status2 == 4) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }else if($subtask_status2 == 5) {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                     }else {

                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                 }else if(!empty($end_due_date) && !empty($start_due_date)) {

                       $user_subtasks = SubTask::whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                 }else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                   if($subtask_status == 2) {
                      $subtask_status = 0;
                   }
                   if($subtask_user_id == "all"){
                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                  }else {
                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->where('subtask_status',$subtask_status)->get();
                   }
                 }else if(!empty($subtask_status)) {
                   if($subtask_status == 2) {
                      $subtask_status = 0;
                   }


                      $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->get();

                 } else {
                      if($subtask_user_id == "all"){
                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->get();
                       }else {
                            $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();
                          }
                 }




                $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                return response()->json(['options'=>$data]);
         }

               //            return view('admin.tasks.mytasks')->with(compact('user_subtasks','status')) ;
        }
        else
        {

               $subtask_status2 = $request->subtask_status2;
                if($request->type == "all") {
                //  dd($request->all());
                  $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                  $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                  if(empty($request->start_due_date)) {
                     $start_due_date = null;
                  }
                  if(empty($request->end_due_date)) {
                       $end_due_date = null;
                  }

                  if(empty($request->end_due_date) && empty($request->start_due_date)) {
                       $end_due_date = null;
                        $start_due_date = null;
                  }

                  $subtask_user_id = $request->subtask_user_id;
                  if(isset($request->subtask_status)) {
                  $subtask_status = $request->subtask_status;
                }else {
                    $subtask_status = null;
                }

                    if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                          if($subtask_status == 2) {
                             $subtask_status = 0;
                          }
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();

                      }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                      }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                          if($subtask_status == 2) {
                             $subtask_status = 0;
                          }
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                      }else if(!empty($end_due_date) && !empty($start_due_date)) {

                            $user_subtasks = SubTask::whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                      }else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->where('subtask_status',$subtask_status)->get();

                      }else if(!empty($subtask_user_id)) {

                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();

                      }else if(!empty($subtask_status)) {
                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->get();

                      } else {

                           $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->get();
                      }

                 // dd($user_subtasks);
                 $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                 return response()->json(['options'=>$data]);



             }

             if($request->type == "date_filter") {

                //  dd('heeeeeeeeel');
                   // $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                   // $end_due_date = date('Y-m-d', strtotime($request->end_due_date));

                   $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                   $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                   if(empty($request->start_due_date)) {
                      $start_due_date = null;
                   }
                   if(empty($request->end_due_date)) {
                        $end_due_date = null;
                   }

                   if(empty($request->end_due_date) && empty($request->start_due_date)) {
                         $end_due_date = null;
                         $start_due_date = null;
                   }

                   $subtask_user_id = $request->subtask_user_id;
                   if(isset($request->subtask_status)) {
                   $subtask_status = $request->subtask_status;
                 }else {
                     $subtask_status = null;
                 }

                       if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                           if($subtask_status == 2) {
                              $subtask_status = 0;
                           }
                           if($subtask_user_id == "all"){
                             if($subtask_status2 == 3) {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                             }else if($subtask_status2 == 4) {
                                      $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                             }else if($subtask_status2 == 5) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                             }else {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                             }
                          }else {
                            if($subtask_status2 == 3) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                            }else if($subtask_status2 == 4) {
                                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                            }else if($subtask_status2 == 5) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                            }else {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                             }
                          }
                       }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                         if($subtask_user_id == "all"){
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }else {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }
                       }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                           if($subtask_status == 2) {
                              $subtask_status = 0;
                           }
                           if($subtask_status2 == 3) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                           }else if($subtask_status2 == 4) {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                           }else if($subtask_status2 == 5) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                           }else {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }
                       } else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                         if($subtask_status == 2) {
                            $subtask_status = 0;
                         }
                         if($subtask_user_id == "all"){
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                          }else {
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->where('subtask_status',$subtask_status)->get();
                           }
                       }else if(!empty($subtask_user_id)) {

                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();

                       }else if(!empty($subtask_status)) {
                         if($subtask_status == 2) {
                            $subtask_status = 0;
                         }
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->get();

                       } else {

                                $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }
               //  dd($start_due_date);
                    $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                    return response()->json(['options'=>$data]);

             }

              if($request->type == "status_filter") {
                //   $subtask_status = $request->subtask_status;
                $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                if(empty($request->start_due_date)) {
                   $start_due_date = null;
                }
                if(empty($request->end_due_date)) {
                     $end_due_date = null;
                }

                if(empty($request->end_due_date) && empty($request->start_due_date)) {
                     $end_due_date = null;
                      $start_due_date = null;
                }


                if(isset($request->subtask_status)) {
                $subtask_status = $request->subtask_status;
              }else {
                  $subtask_status = null;
              }

                  $subtask_user_id = $request->subtask_user_id;
                    // dd($request->all());
                    if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }

                        if($subtask_user_id == "all"){

                          if($subtask_status2 == 3) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }else if($subtask_status2 == 4) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }else if($subtask_status2 == 5) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }else {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                            }
                       }else {

                         if($subtask_status2 == 3) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                         }else if($subtask_status2 == 4) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                         }else if($subtask_status2 == 5) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                         }else {

                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }
                       }
                    }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                      if($subtask_user_id == "all"){
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }else {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }
                    }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }

                        if($subtask_status2 == 3) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 4) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 5) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        }else {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }
                    }else if(!empty($end_due_date) && !empty($start_due_date)) {


                      if($subtask_status2 == 3) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                      }else if($subtask_status2 == 4) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                      }else if($subtask_status2 == 5) {
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                      }else {
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }


                    }else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                      if($subtask_status == 2) {
                         $subtask_status = 0;
                      }
                      if($subtask_user_id == "all"){
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                     }else {
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->where('subtask_status',$subtask_status)->get();
                      }
                    }else if(!empty($subtask_user_id)) {

                      if($subtask_user_id == "all"){
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->get();
                     }else {
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();
                      }
                    } else {
                            if($subtask_status == 2) {
                               $subtask_status = 0;
                            }

                              $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                    }
                    $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                    return response()->json(['options'=>$data]);

             }

              if($request->type == "user_filter") {


                //   $subtask_user_id = $request->subtask_user_id;

            // dd( $subtask_user_id);
                 $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                 $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                 if(empty($request->start_due_date)) {
                    $start_due_date = null;
                 }
                 if(empty($request->end_due_date)) {
                      $end_due_date = null;
                 }

                 if(empty($request->end_due_date) && empty($request->start_due_date)) {
                      $end_due_date = null;
                       $start_due_date = null;
                 }

                 $subtask_user_id = $request->subtask_user_id;
                 if(isset($request->subtask_status)) {
                 $subtask_status = $request->subtask_status;
               }else {
                   $subtask_status = null;
               }

                     if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                         if($subtask_status == 2) {
                            $subtask_status = 0;
                         }
                         if($subtask_user_id == "all"){

                                   if($subtask_status2 == 3) {
                                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                   }else if($subtask_status2 == 4) {
                                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                   }else if($subtask_status2 == 5) {
                                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                   }else {
                                      $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                   }
                        }else {
                          if($subtask_status2 == 3) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }else if($subtask_status2 == 4) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }else if($subtask_status2 == 5) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }else {

                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                            }
                        }
                     }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                       if($subtask_user_id == "all"){

                         if($subtask_status2 == 3) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 4) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 5) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                         }else {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }
                      }else {
                        if($subtask_status2 == 3) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 4) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 5) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        }else {
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                         }
                       }
                     }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                         if($subtask_status == 2) {
                            $subtask_status = 0;
                         }

                         if($subtask_status2 == 3) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 4) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 5) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                         }else {

                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }
                     }else if(!empty($end_due_date) && !empty($start_due_date)) {

                       if($subtask_status2 == 3) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                       }else if($subtask_status2 == 4) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }else if($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                       }else {

                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                         }
                     }else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                       if($subtask_status == 2) {
                          $subtask_status = 0;
                       }
                       if($subtask_user_id == "all"){
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->where('subtask_status',$subtask_status)->get();
                      }else {
                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->where('subtask_status',$subtask_status)->get();
                       }
                     }else if(!empty($subtask_status)) {
                       if($subtask_status == 2) {
                          $subtask_status = 0;
                       }


                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->get();

                     } else {
                          if($subtask_user_id == "all"){
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->get();
                           }else {
                                $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();
                              }
                     }


                                 $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                                 return response()->json(['options'=>$data]);
                    }
                      // status2 filter


                      if($request->type == "status2_filter") {
                        //   $subtask_status = $request->subtask_status;

                        //  dd($request->all());
                        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                        if(empty($request->start_due_date)) {
                           $start_due_date = null;
                        }
                        if(empty($request->end_due_date)) {
                             $end_due_date = null;
                        }

                        if(empty($request->end_due_date) && empty($request->start_due_date)) {
                             $end_due_date = null;
                              $start_due_date = null;
                        }


                        if(isset($request->subtask_status)) {
                        $subtask_status = $request->subtask_status;
                      }else {
                          $subtask_status = null;
                      }

                          $subtask_user_id = $request->subtask_user_id;
                            // dd($request->all());
                            if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                                if($subtask_status == 2) {
                                   $subtask_status = 0;
                                }

                                if($subtask_user_id == "all"){

                                  if($subtask_status2 == 3) {
                                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                  }else if($subtask_status2 == 4) {
                                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                  }else if($subtask_status2 == 5) {
                                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                  }else {
                                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                    }
                               }else {

                                 if($subtask_status2 == 3) {
                                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                 }else if($subtask_status2 == 4) {
                                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                 }else if($subtask_status2 == 5) {
                                      $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                 }else {

                                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                  }
                               }
                            }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

                              if($subtask_user_id == "all"){
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                             }else {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                               }
                            }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {

                                if($subtask_status == 2) {
                                   $subtask_status = 0;
                                }

                                if($subtask_status2 == 3) {
                                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                                }else if($subtask_status2 == 4) {
                                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                                }else if($subtask_status2 == 5) {
                                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                                }else {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                                }
                            }else if(!empty($end_due_date) && !empty($start_due_date)) {

                              if($subtask_status2 == 3) {
                                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                              }else if($subtask_status2 == 4) {
                                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                              }else if($subtask_status2 == 5) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                              }else {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                                }


                            }
                            $data = view('admin.subtasks.admin_user_subtasks',compact('user_subtasks','users','gender'))->render();
                            return response()->json(['options'=>$data]);

                     }



                      // End status2 filter




        }
    }

    public function updateLogRead(Request $request) {

   //dd($request->all());
         $log = Log::find($request->log);
         if(empty($log->is_read ) ||  $log->is_read == NULL) {
                 $log->is_read = json_encode(array(Auth::user()->id));
                  $log->save();
         }else {

                $arr = json_decode($log->is_read) ;

                if(!in_array(Auth::user()->id , $arr)) {

                  array_push($arr,Auth::user()->id);
                    $log->is_read = json_encode($arr);
                    $log->save();
               }

         }

       //  return redirect()->route('admin.categories');
 }

 public function guestsubtasks() {
       $tasksids =    TaskGuest::where('account_id' , auth()->user()->account_id)->where('user_id',Auth::user()->id)->pluck('task_id');
       $title = 'Pripo';
       $status = 0 ;
       $user_subtasks =  SubTask::whereIn('task_id',$tasksids)->where('subtask_status',0)->get();
       $users = User::where('account_id' , auth()->user()->account_id)->get();
     //  dd($tasksids);
       return view('admin.tasks.guesttasks')->with(compact('user_subtasks','users','status')) ;

}


// filter guest subtasks


  public function filterguestSubtasks(Request $request )
 {

      $users = User::where('account_id' , auth()->user()->account_id)->get();
      $gender = $request->gender;
      if(empty($gender)) {
        $gender = "list";
      }
     $status = 0 ;
     $subtask_status2 = $request->subtask_status2;

     $tasksids =    TaskGuest::where('account_id' , auth()->user()->account_id)->where('user_id',Auth::user()->id)->pluck('task_id');

             if($request->type == "all") {
             //  dd($request->all());
               $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
               $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
               if(empty($request->start_due_date)) {
                  $start_due_date = null;
               }
               if(empty($request->end_due_date)) {
                    $end_due_date = null;
               }

               if(empty($request->end_due_date) && empty($request->start_due_date)) {
                    $end_due_date = null;
                     $start_due_date = null;
               }

               $subtask_user_id = $request->subtask_user_id;
               if(isset($request->subtask_status)) {
               $subtask_status = $request->subtask_status;
             }else {
                 $subtask_status = null;
             }


                 $tasksids = TaskTeam::where('user_id',$request->id)->pluck('task_id');

                 if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                       if($subtask_status == 2) {
                          $subtask_status = 0;
                       }
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();

                   }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                   }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                       if($subtask_status == 2) {
                          $subtask_status = 0;
                       }
                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                   }else if(!empty($end_due_date) && !empty($start_due_date)) {

                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                   }else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }
                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();

                   }else if(!empty($subtask_user_id)) {

                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->get();

                   }else if(!empty($subtask_status)) {
                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();

                   } else {

                        $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->get();
                   }

              // dd($user_subtasks);
              $data = view('admin.subtasks.admin_guest_subtasks',compact('user_subtasks','users','gender'))->render();
              return response()->json(['options'=>$data]);



          }

          if($request->type == "date_filter") {

             //  dd('heeeeeeeeel');
                // $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                // $end_due_date = date('Y-m-d', strtotime($request->end_due_date));

                $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                if(empty($request->start_due_date)) {
                   $start_due_date = null;
                }
                if(empty($request->end_due_date)) {
                     $end_due_date = null;
                }

                if(empty($request->end_due_date) && empty($request->start_due_date)) {
                      $end_due_date = null;
                      $start_due_date = null;
                }

                $subtask_user_id = $request->subtask_user_id;
                if(isset($request->subtask_status)) {
                $subtask_status = $request->subtask_status;
              }else {
                  $subtask_status = null;
              }

                    if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }
                        if($subtask_user_id == "all"){
                          if($subtask_status2 == 3) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                          }else if($subtask_status2 == 4) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }else if($subtask_status2 == 5) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                          }else {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }
                       }else {
                         if($subtask_status2 == 3) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 4) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                         }else if($subtask_status2 == 5) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                         }else {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                          }
                       }
                    }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                      if($subtask_user_id == "all"){
                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }else {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }
                    }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                        if($subtask_status == 2) {
                           $subtask_status = 0;
                        }
                        if($subtask_status2 == 3) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 4) {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        }else if($subtask_status2 == 5) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        }else {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                       }
                    } else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                      if($subtask_status == 2) {
                         $subtask_status = 0;
                      }
                      if($subtask_user_id == "all"){
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();
                       }else {
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();
                        }
                    }else if(!empty($subtask_user_id)) {

                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->get();

                    }else if(!empty($subtask_status)) {
                      if($subtask_status == 2) {
                         $subtask_status = 0;
                      }
                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();

                    } else {

                             $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
            //  dd($start_due_date);
                 $data = view('admin.subtasks.admin_guest_subtasks',compact('user_subtasks','users','gender'))->render();
                 return response()->json(['options'=>$data]);

          }

           if($request->type == "status_filter") {
             //   $subtask_status = $request->subtask_status;
             $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
             $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
             if(empty($request->start_due_date)) {
                $start_due_date = null;
             }
             if(empty($request->end_due_date)) {
                  $end_due_date = null;
             }

             if(empty($request->end_due_date) && empty($request->start_due_date)) {
                  $end_due_date = null;
                   $start_due_date = null;
             }


             if(isset($request->subtask_status)) {
             $subtask_status = $request->subtask_status;
           }else {
               $subtask_status = null;
           }

               $subtask_user_id = $request->subtask_user_id;
                 // dd($request->all());
                 if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }

                     if($subtask_user_id == "all"){

                       if($subtask_status2 == 3) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                       }else if($subtask_status2 == 4) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                       }else if($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                       }else {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                         }
                    }else {

                      if($subtask_status2 == 3) {
                             $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                      }else if($subtask_status2 == 4) {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                      }else if($subtask_status2 == 5) {
                           $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                      }else {

                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                       }
                    }
                 }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                   if($subtask_user_id == "all"){
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                  }else {
                         $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                 }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                     if($subtask_status == 2) {
                        $subtask_status = 0;
                     }

                     if($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                     }else if($subtask_status2 == 4) {
                              $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }else if($subtask_status2 == 5) {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                     }else {
                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }
                 }else if(!empty($end_due_date) && !empty($start_due_date)) {


                   if($subtask_status2 == 3) {
                          $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                   }else if($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                   }else if($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                   }else {
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                     }


                 }else if(!empty($subtask_user_id) && !empty($subtask_status)) {
                   if($subtask_status == 2) {
                      $subtask_status = 0;
                   }
                   if($subtask_user_id == "all"){
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();
                  }else {
                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();
                   }
                 }else if(!empty($subtask_user_id)) {

                   if($subtask_user_id == "all"){
                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->get();
                  }else {
                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->get();
                   }
                 } else {
                         if($subtask_status == 2) {
                            $subtask_status = 0;
                         }

                           $user_subtasks =  SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->get();
                 }
                 $data = view('admin.subtasks.admin_guest_subtasks',compact('user_subtasks','users','gender'))->render();
                 return response()->json(['options'=>$data]);

          }



                   if($request->type == "status2_filter") {
                     //   $subtask_status = $request->subtask_status;

                     //  dd($request->all());
                     $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
                     $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
                     if(empty($request->start_due_date)) {
                        $start_due_date = null;
                     }
                     if(empty($request->end_due_date)) {
                          $end_due_date = null;
                     }

                     if(empty($request->end_due_date) && empty($request->start_due_date)) {
                          $end_due_date = null;
                           $start_due_date = null;
                     }


                     if(isset($request->subtask_status)) {
                     $subtask_status = $request->subtask_status;
                   }else {
                       $subtask_status = null;
                   }

                       $subtask_user_id = $request->subtask_user_id;
                         // dd($request->all());
                         if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                             if($subtask_status == 2) {
                                $subtask_status = 0;
                             }

                             if($subtask_user_id == "all"){

                               if($subtask_status2 == 3) {
                                      $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                               }else if($subtask_status2 == 4) {
                                        $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                               }else if($subtask_status2 == 5) {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                               }else {
                                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                                 }
                            }else {

                              if($subtask_status2 == 3) {
                                     $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                              }else if($subtask_status2 == 4) {
                                       $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                              }else if($subtask_status2 == 5) {
                                   $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                              }else {

                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status',$subtask_status)->get();
                               }
                            }
                         }else if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

                           if($subtask_user_id == "all"){
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                          }else {
                                 $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                            }
                         }else if(!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {

                             if($subtask_status == 2) {
                                $subtask_status = 0;
                             }

                             if($subtask_status2 == 3) {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                             }else if($subtask_status2 == 4) {
                                      $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                             }else if($subtask_status2 == 5) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                             }else {
                               $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->where('subtask_status',$subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                             }
                         }else if(!empty($end_due_date) && !empty($start_due_date)) {

                           if($subtask_status2 == 3) {
                                  $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                           }else if($subtask_status2 == 4) {
                                    $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                           }else if($subtask_status2 == 5) {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                           }else {
                                $user_subtasks = SubTask::where('account_id' , auth()->user()->account_id)->whereIn('task_id',$tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                             }


                         }
                         $data = view('admin.subtasks.admin_guest_subtasks',compact('user_subtasks','users','gender'))->render();

                         return response()->json(['options'=>$data]);

                  }



                   // End status2 filter





 }

  // get task SubTasks
  public function getAllSubtasks(Request $request) {
       $task = Task::where('account_id' , auth()->user()->account_id)->where('id' , $request->task_id)->first();
       $users = User::where('account_id' , auth()->user()->account_id)->where('role','!=',3)->get();
       $last_subtask_id = SubTask::where('account_id' , auth()->user()->account_id)->latest()->first()->id;
       if(empty($last_subtask_id)) {
            $last_subtask_id = 0;
       }
       $data = view('admin.tasks.all_subtasks',compact('task','users','last_subtask_id'))->render();
       return response()->json(['options'=>$data]);
  }

 //filter history tasks times
 public  function  filterUserhistorySubtasks(Request $request)
 {

   $users = User::where('account_id' , auth()->user()->account_id)->get();


   $gender = $request->gender;
   if(empty($gender)) {
     $gender = "list";
   }
  $status = 0 ;
  $subtask_status2 = $request->subtask_status2;

  $tasksids =    TaskGuest::where('account_id' , auth()->user()->account_id)->where('user_id',Auth::user()->id)->pluck('task_id');

   if($request->type == "date_filter") {


         $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
         $end_due_date = date('Y-m-d', strtotime($request->end_due_date));


         if(empty($request->start_due_date)) {
            $start_due_date = null;
         }
         if(empty($request->end_due_date)) {
              $end_due_date = null;
         }

         if(empty($request->end_due_date) && empty($request->start_due_date)) {
               $end_due_date = null;
               $start_due_date = null;
         }

         $subtask_user_id = $request->subtask_user_id;

       if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

               if($subtask_user_id == "all"){
                $user_subtasks = SubTask::with('history')->where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }else {
                   $user_subtasks = SubTask::with('history')->where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }
       } else {

                      $user_subtasks =  SubTask::with('history')->where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
       }

         return   response()->json($user_subtasks) ;
          $data = view('admin.subtasks.admin_user_subtaskshistory',compact('user_subtasks','users','gender'))->render();
          return response()->json(['options'=>$data]);
   }


   //userfiltter

   if($request->type == "user_filter") {

      $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
      $end_due_date = date('Y-m-d', strtotime($request->end_due_date));


      if(empty($request->start_due_date)) {
         $start_due_date = null;
      }
      if(empty($request->end_due_date)) {
           $end_due_date = null;
      }

      if(empty($request->end_due_date) && empty($request->start_due_date)) {
           $end_due_date = null;
            $start_due_date = null;
      }

      $subtask_user_id = $request->subtask_user_id;

       if(!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
            if($subtask_user_id == "all"){
             $user_subtasks = SubTask::with('history')->where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
           }else {
                $user_subtasks = SubTask::with('history')->where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
            }
          } else {
               if($subtask_user_id == "all"){
                  $user_subtasks = SubTask::with('history')->where('account_id' , auth()->user()->account_id)->where('subtask_user_id',Auth::user()->id)->get();
                }else {

                      $user_subtasks =  SubTask::with('history')->where('account_id' , auth()->user()->account_id)->where('subtask_user_id',$subtask_user_id)->get();
              }
          }



         $data = view('admin.subtasks.admin_user_subtaskshistory',compact('user_subtasks','users','gender'))->render();
         return response()->json(['options'=>$data]);
  }





 }






}
