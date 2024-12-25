<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\User;
use App\Models\TaskTeam;
use App\Models\TaskGuest;
use App\Models\Category;
use App\Models\Comment;

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
use App\Models\Replay;
use App\Models\TaskTag;

class TasksController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            $minutes_to_add = 10;
            $time = new DateTime(Auth::user()->login_at);
            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            $stamp = $time->format('Y-m-d H:i:s');

            Auth::user()->login_at = $stamp;
            Auth::user()->login_status = 1;
            Auth::user()->save();
            return $next($request);
        });


    }

    public function index()
    {

        $datas = Task::where('account_id', auth()->user()->account_id)->orderBy('task_priority')->get();
        return view('admin.tasks.index', compact('datas'));
    }

    public function copytask(Request $request)
    {

        $copied = Task::where(['id' => $request->copy])->first();
        $data = new Task();
        $data->task_title = $copied->task_title . '- Kopie';
        $data->task_desc = $copied->task_desc;
        $data->task_category_id = $copied->task_category_id;
        $data->task_category_id_two = $copied->task_category_id_two;
        $data->task_added_by = Auth::user()->id;
        $data->task_responsible = $copied->task_responsible;
        $data->task_start_date = $copied->task_start_date;
        $data->task_due_date = date('Y-m-d', strtotime($copied->task_due_date));
        $data->account_id = auth()->user()->account_id;
        $data->save();
        $inserted_id = $data->id;
        //Insert Sub Tasks  on Main Task


        $subtasks = SubTask::where('task_id', $request->copy)->get();
        foreach ($subtasks as $subtask) {
            $subtaskob = new SubTask();
            $subtaskob->subtask_title = $subtask->subtask_title;
            $subtaskob->task_id = $inserted_id;
            $subtaskob->subtask_added_by = $subtask->subtask_added_by;
            $subtaskob->subtask_user_id = $subtask->subtask_user_id;
            $subtaskob->subtask_start_date = $subtask->subtask_start_date;
            $subtaskob->subtask_due_date = $subtask->subtask_due_date;
            $subtaskob->subtask_priority = $subtask->subtask_priority;
            $subtaskob->subtask_status = $subtask->subtask_status;
            $subtaskob->subtask_completed_at = $subtask->subtask_completed_at;
            $subtaskob->account_id = $subtask->account_id;
            $subtaskob->subtask_time = $subtask->subtask_time;
            $subtaskob->save();
        }

        $data->task_priority = $inserted_id;
        $data->save();

        $teamids = TaskTeam::where('task_id', $request->copy)->pluck('user_id');
        // dd($teamids) ;
        for ($i = 0; $i < count($teamids); $i++) {
            $dta = new TaskTeam();
            $dta->user_id = $teamids[$i];
            $dta->task_id = $inserted_id;
            $dta->account_id = auth()->user()->account_id;
            $dta->save();
        }


    }

    public function create()
    {
        $users = User::where('account_id', auth()->user()->account_id)->get();
        $categories = Category::where('account_id', auth()->user()->account_id)->get();
        return view('admin.tasks.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        //  dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
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
            $log->user_name = Auth::user()->user_name;
            $log->user_image = Auth::user()->image;
            //real time event
            event(new NewNotification($log));
            //return redirect()->route('admin.dashboard')->with(['success' => 'Data Added Successfully']);
            if (!empty(session()->get('catt_id')) && empty(session()->get('tagg_id'))) {
                return redirect()->route('admin.cat.tasks', ['cat_id' => session()->get('catt_id'), 'status' => 0])->with(['success' => 'Data Added Successfully']);
            } else if (!empty(session()->get('catt_id')) && !empty(session()->get('tagg_id'))) {
                return redirect()->route('admin.cat.tag.tasks', ['cat_id' => session()->get('catt_id'), 'tag_id' => session()->get('tagg_id'), 'status' => 0])->with(['success' => 'Data Added Successfully']);
            } else {
                return redirect()->route('admin.dashboard')->with(['success' => 'Data Added Successfully']);
            }
        } catch (Exception $e) {
            return redirect()->route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
        }


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = Task::find($id);
        $users = User::where('account_id', auth()->user()->account_id)->get();
        $categories = Category::where('account_id', auth()->user()->account_id)->get();
        return view('admin.tasks.edit', ['data' => $data, 'id' => $id, 'users' => $users, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
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
            return redirect()->route('admin.dashboard')->with(['success' => 'Data Updated Successfully']);
        } catch (Exception $e) {
            return redirect()->route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
        }

    }

    public function delete(Request $request)
    {
        $id = $request->task_id;
        $data = Task::find($id);
        $data->task_status = 2;
        TaskTag::where('task_id' ,$id)->delete();
        $data->save();
        $log = new Log();
        $log->log_desc = Auth::user()->user_name . ' Deleted The Task ' . $data->task_title;
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
            "status" => true,
            "msg" => $msg
        ], 200);
    }


    public function undelete(Request $request)
    {
        $id = $request->task_id;
        // dd($id);
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


    public function markComplete(Request $request)
    {
        $id = $request->task_id;
        // dd($id);
        $data = Task::find($id);
        $data->task_status = 1;
        $data->save();
        $log = new Log();
        $log->log_desc = Auth::user()->user_name . 'Mark The Task ' . $data->task_title . 'Completed';
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
            "status" => true,
            "msg" => $msg
        ], 200);
    }

    public function unmarkComplete(Request $request)
    {
        $id = $request->task_id;
        // dd($id);
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

    public function updateStatus($id)
    {
        $data = Task::find($id);
        if ($data->task_status == 0) {
            $data->task_status = 1;
            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' hat ein Post-it' . $data->task_title . ' erledigt Markiert';
            $log->log_user_id = Auth::user()->id;
            $log->log_task_id = $id;
            $log->account_id = auth()->user()->account_id;
        } else {
            $data->task_status = 0;
            $log = new Log();
            $log->log_desc = Auth::user()->user_name . ' hat ein Post-it' . $data->task_title . ' nicht erledigt Markiert';
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

    public function showTaskData(Request $request)
    {
        $id = $request->id;
        $task = Task::find($id);
        $subtasks = SubTask::where('task_id', $id)->get();
        $teamids = TaskTeam::where('task_id', $id)->pluck('user_id');
        $teams = User::whereIn('id', $teamids)->get();
        $users = User::where('account_id', auth()->user()->account_id)->where('deleted', 0 )->where('role', '!=', 3)->get();
        $users3 = User::where('account_id', auth()->user()->account_id)->where('deleted', 0 )->where('role', '!=', 3)->get();
        $users_gests = User::where('account_id', auth()->user()->account_id)->where('deleted', 0 )->whereIn('role', [1, 2, 3])->get();
        $cats = Category::where('account_id', auth()->user()->account_id)->get();
        $tags = Tag::where('account_id', auth()->user()->account_id)->distinct('tag_name')->get('tag_name');
        $users2 = User::where('account_id', auth()->user()->account_id)->where('deleted', 0 )->where('role', 3)->get();
        if (count($subtasks) > 0) {
            $last_subtask_id = SubTask::where('account_id', auth()->user()->account_id)->latest()->first()->id;
        }
        if (empty($last_subtask_id)) {
            $last_subtask_id = 0;
        }

        if(isset($request->comment_id) && !empty($request->comment_id)) {
            $comment = Comment::find($request->comment_id);
            if (empty($comment->readby) || $comment->readby == NULL) {
                $comment->readby = json_encode(array(Auth::user()->id));
                $comment->save();
            } else {
                $arr = json_decode($comment->readby);
                if (!in_array(Auth::user()->id, $arr)) {
                    array_push($arr, Auth::user()->id);
                    $comment->readby = json_encode($arr);
                    $comment->save();
                }

            }
        }

        if ($request->type == '1') {
            return view('admin.tasks.popup', ['task' => $task, 'users' => $users, 'users2' => $users2, 'teams' => $teams, 'subtasks' => $subtasks, 'cats' => $cats, 'id' => $id, 'last_subtask_id' => $last_subtask_id, 'tags' => $tags, 'users3' => $users3, 'users_gests' => $users_gests]);
        } else {
            return view('admin.tasks.popup2', ['task' => $task, 'users' => $users, 'users2' => $users2, 'teams' => $teams, 'subtasks' => $subtasks, 'cats' => $cats, 'id' => $id, 'last_subtask_id' => $last_subtask_id, 'tags' => $tags, 'users3' => $users3, 'users_gests' => $users_gests]);
        }

    }

    // getCreateView

    public function getCreateView(Request $request)
    {
        $type = $request->type;
        $users = User::where('account_id', auth()->user()->account_id)->where('role', '!=', 3)->get();
        $users2 = User::where('account_id', auth()->user()->account_id)->where('role', 3)->get();
        $categories = Category::where('account_id', auth()->user()->account_id)->get();
        $tags = Tag::where('account_id', auth()->user()->account_id)->distinct('tag_name')->get('tag_name');
        //  dd($tags);
        return view('admin.tasks.' . $type, ['users' => $users, 'users2' => $users2, 'categories' => $categories, 'tags' => $tags]);
    }

    public function sorting(Request $request)
    {
        $perorityList = $request->all();
        if ($request->isMethod('POST')) {
            foreach ($request->list as $key => $taksId) {
                $d = Task::find($taksId);
                if (!empty($d)) {
                    $d->task_priority = $key;
                    $d->save();
                }
            }
        }
    }

    public function updateTaskfield(Request $request)
    {
        //  dd($request->all());
        DB::beginTransaction();

        $id = $request->task_id;
        $data = Task::find($id);

        $cat_id = $data->task_category_id;

        if ($request->field_name == 'teams_id') {
            //   dd($request->field_val);
            if (!empty($request->field_val)) {
                TaskTeam::where('task_id', $id)->delete();
                $interest_array = $request->field_val;
                $array_len = count($interest_array);
                for ($i = 0; $i < $array_len; $i++) {
                   /*
                    if ($interest_array[$i] == Auth::user()->id || $interest_array[$i] == $data->task_responsible) {
                        continue;
                    } else {
                        */
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
                        /*
                                }
                        */

                }

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


            // date('Y-m-d', strtotime($request->task_due_date));


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

        DB::commit();

        $task = Task::find($id);
        $data = view('admin.tasks.single_task', compact('task'))->render();

        if ($request->field_name == 'task_category_id' && $request->field_val != $cat_id) {

            return response()->json(['options' => 'no', 'options2' => $data]);
        } else {
            return response()->json(['options' => $data]);
        }


    }

    public function usertasks(Request $request)
    {
        // Data Displyed on admin Tasks
        $status = 0;
        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status',0)->orderBy('created_at','DESC')->get();
        $users = User::where('account_id', auth()->user()->account_id)->get();
        return view('admin.tasks.admintasks')->with(compact('user_subtasks', 'users', 'status'));

    }
    public function orderadminsubtasks(Request $request)
    {
         $data        =     $request->slecteddata ;
         $cuurentItem  =    $request->cuurentItem ;


         $position    =     $request->newposition ;
         $currentitem =    $request->cuurentItemIndex ;
         if($position > $currentitem){
             $newelement   =    $data[$position-1] ;
         }else
         {
             $newelement   =    $data[$position+1] ;
         }

        foreach ($data as  $order)
        {
            $currentitem = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status',0)->where('id', $cuurentItem )->first();
            $current = $currentitem->suborder ;
        }
        foreach ($data as  $order)
        {
            $neworder = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status',0)->where('id', $newelement )->first();
            $neworderr = $neworder->suborder ;
        }
        $currentitem->suborder = $neworderr;
        $neworder->suborder = $current ;
        $currentitem->save() ;
        $neworder->save() ;
        return response('Update Successfully.', 200);
    }
    public function filterUserSubtasks(Request $request)
    {

        $users = User::where('account_id', auth()->user()->account_id)->get();
        $gender = $request->gender;
        $sorting = $request->sorting ;
        if($sorting == 6 )
        {
            $sort = 'created_at' ;
        }else
        {
            $sort = 'suborder' ;
        }
        if (empty($gender)) {
            $gender = "list";
        }
        if (Auth::user()->role == 2) {
            $subtask_status2 = $request->subtask_status2;
            $subtask_user_id = Auth::user()->id;
            if ($request->type == "status2_filter") {
                //   $subtask_status = $request->subtask_status;
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


                if (isset($request->subtask_status)) {
                    $subtask_status = $request->subtask_status;
                } else {
                    $subtask_status = null;
                }
                $subtask_user_id = $request->subtask_user_id;
                if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    if ($subtask_user_id == "all") {
                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        } else {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    } else {
                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        } else {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    }
                } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                } else if (!empty($end_due_date) && !empty($start_due_date)) {

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }


                }

                //dd($user_subtasks);
                $data = view('admin.subtasks.admin_user_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
                return response()->json(['options' => $data]);

            }


            // End status2 filter

            if ($request->type == "date_filter") {

                $start_due_date = date('Y-m-d H:i:s', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d H:i:s', strtotime($request->end_due_date));
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
                if (isset($request->subtask_status)) {
                    $subtask_status = $request->subtask_status;
                } else {
                    $subtask_status = null;
                }
                $subtask_status2 = $request->subtask_status2;

                if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status))
                {

                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    if ($subtask_user_id == "all") {
                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        } else {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    } else {

                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        } else {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    }
                } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->with('history')->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->with('history')->get();
                    }
                } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)
                            ->where('subtask_user_id', Auth::user()->id)
                            ->where('subtask_status', $subtask_status)
                            ->whereBetween('created_at', [$start_due_date, $end_due_date])
                            ->orderBy('created_at','DESC')
                            ->with('history')
                            ->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)
                            ->where('subtask_user_id', Auth::user()->id)
                            ->where('subtask_status', $subtask_status)
                            ->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])
                            ->orderBy('created_at','DESC')
                            ->with('history')
                            ->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)
                            ->where('subtask_status', $subtask_status)
                            ->where('subtask_user_id', Auth::user()->id)
                            ->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])
                            ->orderBy('created_at','DESC')
                            ->with('history')
                            ->get();
                    } else {

                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)
                            ->where('subtask_status', $subtask_status)
                            ->where('subtask_user_id', Auth::user()->id)
                            ->whereBetween('created_at', [$start_due_date, $end_due_date])
                            ->orderBy('created_at','DESC')
                            ->with('history')
                            ->get();
                    }
                } else if (!empty($subtask_user_id) && !empty($subtask_status)) {


                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->with('history')->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->where('subtask_status', $subtask_status)->with('history')->get();
                    }
                } else if (!empty($subtask_user_id)) {

                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->with('history')->get();

                } else if (!empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)
                        ->where('subtask_status', $subtask_status)
                        ->where('subtask_user_id', Auth::user()->id)
                        ->with('history')
                        ->get();

                } else {

                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)
                        ->where('subtask_user_id', Auth::user()->id)
                        ->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])
                        ->orderBy('created_at')
                        ->with('history')
                        ->get();

                }

                foreach ($user_subtasks as $subtask) {
                    $subtask['timer_sec'] = $subtask->history->sum('Time');
                }
                $total_tasks_time = $user_subtasks->sum('timer_sec');
                $total_tasks_time = gmdate("H:i:s", $total_tasks_time);

                //  dd($start_due_date);
                $data = view('admin.subtasks.admin_user_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
                return response()->json(['options' => $data, 'total_time' => $total_tasks_time]);
            }


            if ($request->type == "status_filter") {
                //   $subtask_status = $request->subtask_status;

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


                if (isset($request->subtask_status)) {
                    $subtask_status = $request->subtask_status;
                } else {
                    $subtask_status = null;
                }

                $subtask_user_id = $request->subtask_user_id;
                // dd($request->all());
                if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }

                    if ($subtask_user_id == "all") {

                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        } else {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    } else {

                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        } else {

                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    }
                } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                } else if (!empty($end_due_date) && !empty($start_due_date)) {

                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                } else if (!empty($subtask_user_id) && !empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->where('subtask_status', $subtask_status)->get();
                    }
                } else if (!empty($subtask_user_id)) {

                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->get();
                    }
                } else {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }

                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->with('history')->get();
                    foreach ($user_subtasks as $subtask) {
                        $subtask['timer_sec'] = $subtask->history->sum('Time');
                    }
                    $total_tasks_time = $user_subtasks->sum('timer_sec');
                    $total_tasks_time = gmdate("H:i:s", $total_tasks_time);
                }
                $data = view('admin.subtasks.admin_user_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
                return response()->json(['options' => $data]);

            }

            if ($request->type == "user_filter") {

                //   $subtask_user_id = $request->subtask_user_id;
                // dd( $subtask_user_id);
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
                if (isset($request->subtask_status)) {
                    $subtask_status = $request->subtask_status;
                } else {
                    $subtask_status = null;
                }

                if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    if ($subtask_user_id == "all") {

                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        } else {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    } else {
                        if ($subtask_status2 == 3) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', $subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 4) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                        } else if ($subtask_status2 == 5) {
                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                        } else {

                            $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                        }
                    }
                } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                    } else {

                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    }
                } else if (!empty($end_due_date) && !empty($start_due_date)) {

                    $user_subtasks = SubTask::whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

                } else if (!empty($subtask_user_id) && !empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', Auth::user()->id)->where('subtask_status', $subtask_status)->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', $subtask_user_id)->where('subtask_status', $subtask_status)->get();
                    }
                } else if (!empty($subtask_status)) {
                    if ($subtask_status == 2) {
                        $subtask_status = 0;
                    }


                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_status', $subtask_status)->get();

                } else {
                    if ($subtask_user_id == "all") {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', Auth::user()->id)->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->with('history')->where('subtask_user_id', $subtask_user_id)->get();
                    }
                }
                foreach ($user_subtasks as $subtask) {
                    $subtask['timer_sec'] = $subtask->history->sum('Time');
                }
                $total_tasks_time = $user_subtasks->sum('timer_sec');
                $total_tasks_time = gmdate("H:i:s", $total_tasks_time);


                $data = view('admin.subtasks.admin_user_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
                return response()->json(['options' => $data, 'total_time' => $total_tasks_time]);
            }

            //            return view('admin.tasks.mytasks')->with(compact('user_subtasks','status')) ;
        }
        else {
            $subtask_status2 = $request->subtask_status2;
            if ($request->type == "date_filter") {
                $start_due_date = date('Y-m-d H:i:s', strtotime($request->start_due_date));
                $end_due_date = date('Y-m-d H:i:s', strtotime($request->end_due_date));
                if (empty($request->start_due_date)) {
                    $start_due_date = null;
                }
                if (isset($request->subtask_status)) {
                    $subtask_status = $request->subtask_status;
                } else {
                    $subtask_status = null;
                }
                if (empty($request->end_due_date)) {
                    $end_due_date = null;
                }
                if (empty($request->end_due_date) && empty($request->start_due_date)) {
                    $end_due_date = null;
                    $start_due_date = null;
                }

                $subtask_user_id = $request->subtask_user_id;
                // user && start date && end date
                if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {
                    // Ordering  on created At
                    if($sorting == 6 ) {
                                 if ($subtask_status == 2) {  //Get Pending  subtasks
                                    $subtask_status = 0;
                                 }
                                if ($subtask_user_id == "all") {
                                    // check if  created
                                    if ($subtask_status2 == 3) {
                                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->where('subtask_status' , $subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->with('history')->orderBy('created_at', 'DESC')->get();
                                    } // check if  due date
                                    else if ($subtask_status2 == 4) {
                                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->with('history')->where('subtask_status', $subtask_status)->orderBy('created_at', 'DESC')->get();
                                    } else {
                                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->orderBy('created_at', 'DESC')->with('history')->get();
                                    }
                                } else {
                                    if ($subtask_status2 == 4) {
                                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->where('subtask_status' , $subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->with('history')->orderBy('created_at', 'DESC')->get();
                                    } else if ($subtask_status2 == 4) {

                                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->where('subtask_status' , $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->with('history')->orderBy('created_at', 'DESC')->get();
                                    } else {

                                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->where('subtask_status' , $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->orderBy('created_at', 'DESC')->with('history')->get();
                                    }
                                }
                    } //end  ordering  created  at
                    else
                    {
                        if ($subtask_status == 2) {  //Get Pending  subtasks
                            $subtask_status = 0;
                        }
                        if ($subtask_user_id == "all") {
                            // check if  created
                            if ($subtask_status2 == 3) {
                                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status' , $subtask_status)->with('history')->orderBy('suborder', 'ASC')->get();
                            } // check if  due date
                            else if ($subtask_status2 == 4) {
                                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status' , $subtask_status)->with('history')->orderBy('suborder', 'ASC')->get();
                            } else {
                                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->orderBy('suborder', 'ASC')->with('history')->get();
                            }
                        } else {
                            if ($subtask_status2 == 4) {

                                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status' , $subtask_status)->with('history')->orderBy('suborder', 'ASC')->get();
                            } else if ($subtask_status2 == 4) {

                                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status' , $subtask_status)->with('history')->orderBy('suborder', 'ASC')->get();
                            } else {

                                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->orderBy('suborder', 'ASC')->with('history')->get();
                            }
                        }
                    }
                } // user && start date && end date
                else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->where('subtask_user_id', Auth::user()->id)->whereBetween('created_at', [$start_due_date, $end_due_date])->with('history')->get();
                }
                foreach ($user_subtasks as $subtask) {
                    $subtask['timer_sec'] = $subtask->history->sum('Time');
                }

                $total_tasks_time = $user_subtasks->sum('timer_sec');
                $total_tasks_time = gmdate("H:i:s", $total_tasks_time);

                $data = view('admin.subtasks.admin_user_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
                return response()->json(['options' => $data, 'total_time' => $total_tasks_time]);
            }
        }
    }

    public function updateLogRead(Request $request)
    {

        $log = Log::find($request->log);
        if (empty($log->is_read) || $log->is_read == NULL) {
            $log->is_read = json_encode(array(Auth::user()->id));
            $log->save();
        } else {

            $arr = json_decode($log->is_read);

            if (!in_array(Auth::user()->id, $arr)) {

                array_push($arr, Auth::user()->id);
                $log->is_read = json_encode($arr);
                $log->save();
            }

        }

        //  return redirect()->route('admin.categories');
    }

    public function updatereplay(Request $request)
    {
        $replay = Replay::find($request->replay_id);
        if (empty($replay->is_read) || $replay->is_read == NULL) {
            $replay->is_read = json_encode(array(Auth::user()->id));
            $replay->save();
        } else {
            $arr = json_decode($replay->is_read);
            if (!in_array(Auth::user()->id, $arr)) {
                array_push($arr, Auth::user()->id);
                $replay->is_read = json_encode($arr);
                $replay->save();
            }

        }
    }

    public function commentread (Request $request)
    {
        $comment = Comment::find($request->comment_id);
        if (empty($comment->readby) || $comment->readby == NULL) {
            $comment->readby = json_encode(array(Auth::user()->id));
            $comment->save();
        } else {
            $arr = json_decode($comment->readby);
            if (!in_array(Auth::user()->id, $arr)) {
                array_push($arr, Auth::user()->id);
                $comment->readby = json_encode($arr);
                $comment->save();
            }

        }
    }

    public function guestsubtasks()
    {
        $tasksids = TaskGuest::where('account_id', auth()->user()->account_id)->where('user_id', Auth::user()->id)->pluck('task_id');
        $title = 'Pripo';
        $status = 0;
        $user_subtasks = SubTask::whereIn('task_id', $tasksids)->where('subtask_status', 0)->get();
        $users = User::where('account_id', auth()->user()->account_id)->get();
        //  dd($tasksids);
        return view('admin.tasks.guesttasks')->with(compact('user_subtasks', 'users', 'status'));

    }

// filter guest subtasks

    public function updatereplaynotify (Request $request)
    {
        $replay_id  = (int)$request->replay_id ;
        $replay = Replay::find($replay_id);
        if(!empty($replay)) {
            if (empty($replay->is_readnotify) || $replay->is_readnotify == NULL) {
                $replay->is_readnotify = json_encode(array(Auth::user()->id));
                $replay->save();
            } else {
                $arr = json_decode($replay->is_readnotify);
                if (!in_array(Auth::user()->id, $arr)) {
                    array_push($arr, Auth::user()->id);
                    $replay->is_readnotify = json_encode($arr);
                    $replay->save();
                }
            }
        }
    }

    public function updatecommentnotify(Request $request)
    {
        $comment_id  = (int)$request->comment_id ;
        $comment = Comment::find($comment_id);
        if(!empty($comment)) {
            if (empty($comment->is_readnotify) || $comment->is_readnotify == NULL) {
                $comment->is_readnotify = json_encode(array(Auth::user()->id));
                $comment->save();
            } else {
                $arr = json_decode($comment->is_readnotify);
                if (!in_array(Auth::user()->id, $arr)) {
                    array_push($arr, Auth::user()->id);
                    $comment->is_readnotify = json_encode($arr);
                    $comment->save();
                }
            }
        }

    }
    public function filterguestSubtasks(Request $request)
    {

        $users = User::where('account_id', auth()->user()->account_id)->get();
        $gender = $request->gender;
        if (empty($gender)) {
            $gender = "list";
        }
        $status = 0;
        $subtask_status2 = $request->subtask_status2;

        $tasksids = TaskGuest::where('account_id', auth()->user()->account_id)->where('user_id', Auth::user()->id)->pluck('task_id');

        if ($request->type == "all") {
            //  dd($request->all());
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
            if (isset($request->subtask_status)) {
                $subtask_status = $request->subtask_status;
            } else {
                $subtask_status = null;
            }


            $tasksids = TaskTeam::where('user_id', $request->id)->pluck('task_id');

            if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();

            } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

            } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

            } else if (!empty($end_due_date) && !empty($start_due_date)) {

                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();

            } else if (!empty($subtask_user_id) && !empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();

            } else if (!empty($subtask_user_id)) {

                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->get();

            } else if (!empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();

            } else {

                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->get();
            }

            // dd($user_subtasks);
            $data = view('admin.subtasks.admin_guest_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
            return response()->json(['options' => $data]);


        }

        if ($request->type == "date_filter") {

            //  dd('heeeeeeeeel');
            // $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
            // $end_due_date = date('Y-m-d', strtotime($request->end_due_date));

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
            if (isset($request->subtask_status)) {
                $subtask_status = $request->subtask_status;
            } else {
                $subtask_status = null;
            }

            if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                if ($subtask_user_id == "all") {
                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    }
                } else {
                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    }
                }
            } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                if ($subtask_user_id == "all") {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }
            } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                if ($subtask_status2 == 3) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 4) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 5) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }
            } else if (!empty($subtask_user_id) && !empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                if ($subtask_user_id == "all") {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();
                }
            } else if (!empty($subtask_user_id)) {

                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->get();

            } else if (!empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();

            } else {

                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
            }
            //  dd($start_due_date);
            $data = view('admin.subtasks.admin_guest_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
            return response()->json(['options' => $data]);

        }

        if ($request->type == "status_filter") {
            //   $subtask_status = $request->subtask_status;
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


            if (isset($request->subtask_status)) {
                $subtask_status = $request->subtask_status;
            } else {
                $subtask_status = null;
            }

            $subtask_user_id = $request->subtask_user_id;
            // dd($request->all());
            if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }

                if ($subtask_user_id == "all") {

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    }
                } else {

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else {

                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    }
                }
            } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {
                if ($subtask_user_id == "all") {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }
            } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }

                if ($subtask_status2 == 3) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 4) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 5) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }
            } else if (!empty($end_due_date) && !empty($start_due_date)) {


                if ($subtask_status2 == 3) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 4) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 5) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }


            } else if (!empty($subtask_user_id) && !empty($subtask_status)) {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }
                if ($subtask_user_id == "all") {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();
                }
            } else if (!empty($subtask_user_id)) {

                if ($subtask_user_id == "all") {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->get();
                }
            } else {
                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }

                $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->get();
            }
            $data = view('admin.subtasks.admin_guest_subtasks', compact('user_subtasks', 'users', 'gender'))->render();
            return response()->json(['options' => $data]);

        }


        if ($request->type == "status2_filter") {
            //   $subtask_status = $request->subtask_status;

            //  dd($request->all());
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


            if (isset($request->subtask_status)) {
                $subtask_status = $request->subtask_status;
            } else {
                $subtask_status = null;
            }

            $subtask_user_id = $request->subtask_user_id;
            // dd($request->all());
            if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && !empty($subtask_status)) {

                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }

                if ($subtask_user_id == "all") {

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    }
                } else {

                    if ($subtask_status2 == 3) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 4) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else if ($subtask_status2 == 5) {
                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    } else {

                        $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->where('subtask_status', $subtask_status)->get();
                    }
                }
            } else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date)) {

                if ($subtask_user_id == "all") {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }
            } else if (!empty($end_due_date) && !empty($start_due_date) && !empty($subtask_status)) {

                if ($subtask_status == 2) {
                    $subtask_status = 0;
                }

                if ($subtask_status2 == 3) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 4) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 5) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->where('subtask_status', $subtask_status)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }
            } else if (!empty($end_due_date) && !empty($start_due_date)) {

                if ($subtask_status2 == 3) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 4) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                } else if ($subtask_status2 == 5) {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_completed_at', [$start_due_date, $end_due_date])->get();
                } else {
                    $user_subtasks = SubTask::where('account_id', auth()->user()->account_id)->whereIn('task_id', $tasksids)->whereBetween('subtask_due_date', [$start_due_date, $end_due_date])->get();
                }


            }
            $data = view('admin.subtasks.admin_guest_subtasks', compact('user_subtasks', 'users', 'gender'))->render();

            return response()->json(['options' => $data]);

        }


    }

    // get task SubTasks
    public function getAllSubtasks(Request $request)
    {
        $task = Task::where('account_id', auth()->user()->account_id)->where('id', $request->task_id)->first();
        $users = User::where('account_id', auth()->user()->account_id)->where('role', '!=', 3)->get();
        $last_subtask_id = SubTask::where('account_id', auth()->user()->account_id)->latest()->first()->id;
        if (empty($last_subtask_id)) {
            $last_subtask_id = 0;
        }
        $data = view('admin.tasks.all_subtasks', compact('task', 'users', 'last_subtask_id'))->render();
        return response()->json(['options' => $data]);
    }

    //filter history tasks times


    public function filterUserhistorySubtasks(Request $request)
    {

        if (Auth::user()->role == 2) {
            //Display  Admin Filte
            $users = User::where('account_id', auth()->user()->account_id)->get();
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
                    $user_subtasks = SubTask::whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                        $query->whereBetween('created_at', [$start_due_date, $end_due_date]);
                    })->where('subtask_user_id', Auth::user()->id)->get();

                }
                $data = view('admin.subtasks.admin_user_subtaskshistory', compact('user_subtasks', 'users', 'gender'))->render();
                return response()->json(['options' => $data]);
            }
        } else {
            //Display  Admin Filte
            $users = User::where('account_id', auth()->user()->account_id)->get();
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

                        $user_subtasks = SubTask::with('history')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                    } else {
                        $user_subtasks = SubTask::whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                            $query->whereBetween('created_at', [$start_due_date, $end_due_date]);
                        })->where('subtask_user_id', $subtask_user_id)->get();
                    }

                } // when two dates only is not  equal two us
                else if (empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && $start_due_date != $end_due_date) {

                    $user_subtasks = SubTask::with('history')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                } // WHEN Start  Date Is Equal  To  End Date All Dates Between It
                else if (!empty($subtask_user_id) && !empty($start_due_date) && !empty($end_due_date) && $start_due_date == $end_due_date) {
                        if($subtask_user_id == 'all')
                        {
                            $user_subtasks = SubTask::whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                                $query->whereBetween('created_at', [$start_due_date . " 00:00:00", $end_due_date . " 23:59:59"]);
                            })->get();

                        }
                        else
                        {
                            $user_subtasks = SubTask::whereHas('history', function ($query) use ($start_due_date, &$end_due_date) {
                                $query->whereBetween('created_at', [$start_due_date . " 00:00:00", $end_due_date . " 23:59:59"]);
                            })->where('subtask_user_id', $subtask_user_id)->get();
                        }


                }

                $data = view('admin.subtasks.admin_user_subtaskshistory', compact('user_subtasks', 'users', 'gender'))->render();
                return response()->json(['options' => $data]);
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
                        $user_subtasks = SubTask::with('history')->where('account_id', auth()->user()->account_id)->get();
                    } else {

                        $user_subtasks = SubTask::with('history')->where('account_id', auth()->user()->account_id)->where('subtask_user_id', $subtask_user_id)->get();
                    }
                }
            }
        }

        $data = view('admin.subtasks.admin_user_subtaskshistory', compact('user_subtasks', 'users', 'gender'))->render();
        return response()->json(['options' => $data]);
    }


}
