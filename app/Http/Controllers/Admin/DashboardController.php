<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\SubTask;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use App\Models\TaskTeam;
use App\Models\TaskGuest;
use App\Models\TaskTag;
use App\Models\Tag;
use App\Models\Log;
use App\Models\InviteUser;
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    //  public function index($type=null){
    //      if($type) {
    //          if($type == 'completed') {
    //                $tasks = Task::orderBy('task_priority' , 'asc')->where('task_status' , 1)->get();
    //                $title = 'Pripo Completed';
    //                $status = 1;
    //          }else if($type == 'deleted') {
    //                $tasks = Task::orderBy('task_priority' , 'asc')->where('task_status' , 2)->get();
    //                $title = 'Pripo Deleted';
    //                $status = 2;
    //          }else {
    //              $tasks = Task::orderBy('task_priority' , 'asc')->where('task_status' , 0)->get();
    //              $title = 'Pripo';
    //              $status = 0;
    //          }
    //      }else {
    //            $tasks = Task::orderBy('task_priority' , 'asc')->where('task_status' , 0)->get();
    //            $title = 'Pripo';
    //            $status = 0;
    //      }
    //
    //     $categories = Category::all();
    //     return view('admin.dashboard',compact('tasks','categories','title','status'));
    // }

    public function index($type = null)
    {
        session()->forget('catt_id');
        session()->forget('tagg_id');

        $idea = Task::where(['type' =>  1])->first() ;

        if (auth()->user()->role != 3) {

            $invited_userids = InviteUser::where('inviter_id', auth()->user()->id)->where('active', 1)->pluck('user_id');
            $invited_users = User::whereIn('id', $invited_userids)->where('status' , 0)->get();
            $catsids = Category::where('account_id', auth()->user()->account_id)->pluck('id');

            if ($type) {
                if ($type == 'completed') {

                    $categories = Category::where('account_id', auth()->user()->account_id)->with('completed_tasks')->get()->map(function ($cat) {
                        $cat->setRelation('tasks', $cat->tasks->take(2));
                        return $cat;
                    });
                    $title = 'Pripo Completed';
                    $status = 1;
                } else if ($type == 'deleted') {


                    $categories = Category::where('account_id', auth()->user()->account_id)->with('deleted_tasks')->get()->map(function ($cat) {
                        $cat->setRelation('tasks', $cat->tasks->take(2));
                        return $cat;
                    });
                    $title = 'Pripo Deleted';
                    $status = 2;
                } else {

                    $categories = Category::where('account_id', auth()->user()->account_id)->with('tasks')->get()->map(function ($cat) {
                        $cat->setRelation('tasks', $cat->tasks->take(2));
                        return $cat;
                    });
                    $title = 'Pripo';
                    $status = 0;
                }
            } else {
                //All Task On Dashboard
                $categories = Category::where('account_id', auth()->user()->account_id)->with('tasks')->get()->map(function ($cat) {
                    $cat->setRelation('tasks', $cat->tasks->take(2));
                    return $cat;
                });
                $title = 'Pripo';
                $status = 0;
            }


            //dd($categories);
            $users = User::where('account_id', auth()->user()->account_id)->where('role', '!=', 3)->where('status', 0)->where('deleted', 0)->orderBy('user_piriority', 'desc')->get();
            return view('admin.dashboard', compact('categories', 'title', 'status', 'users', 'invited_users' ,'idea'));

        } else {

            $tasksids = TaskGuest::where('user_id', Auth::user()->id)->pluck('task_id');
            $tasks = Task::whereIn('id', $tasksids)->get();
            $title = 'Pripo';
            $catids1 = Task::whereIn('id', $tasksids)->pluck('task_category_id');
            $catids2 = Task::whereIn('id', $tasksids)->pluck('task_category_id_two');

            if (!empty($catids1) && !empty($catids2)) {
                $guestcats = Category::whereIn('id', $catids1)->orWhereIn('id', $catids2)->distinct()->get();
            } else {
                $guestcats = [];
            }
            // dd($tasks);
            return view('admin.guest_dashboard', compact('tasks', 'title', 'guestcats' , 'idea'));
        }
    }


    public function guest_index()
    {

        $tasksids = TaskGuest::where('user_id', Auth::user()->id)->pluck('task_id');
        $tasks = Task::whereIn('id', $tasksids)->get();
        $title = 'Pripo';
        $catids1 = Task::whereIn('id', $tasksids)->pluck('task_category_id');
        $catids2 = Task::whereIn('id', $tasksids)->pluck('task_category_id_two');
        //  dd($catids2);
        if (!empty($catids1) && !empty($catids2)) {
            $guestcats = Category::whereIn('id', $catids1)->orWhereIn('id', $catids2)->distinct()->get();
        } else {
            $guestcats = [];
        }
        // dd($tasks);
        return view('admin.guest_dashboard', compact('tasks', 'title', 'guestcats'));


    }

    public function edit_piriority_ajax()
    {

    }


    public function filterByCategory(Request $request)
    {

        $tasksids = \App\Models\TaskTeam::where('user_id', auth()->user()->id)->pluck('task_id');

        if ($request->type == "guest" && isset($request->type)) {
            session()->forget('catt_id');
            session()->forget('tagg_id');
            $status = $request->status;
            $tasksids = TaskGuest::where('user_id', Auth::user()->id)->pluck('task_id');
            $catids1 = Task::whereIn('id', $tasksids)->pluck('task_category_id');
            $catids2 = Task::whereIn('id', $tasksids)->pluck('task_category_id_two');
            //  dd($catids2);

            if ($request->id == "all") {


                $tasks = Task::orderBy('task_priority', 'asc')->whereIn('id', $tasksids)->get();
                $data = view('admin.tasks.filter_by_category2', compact('tasks'))->render();
                return response()->json(['options' => $data]);
            } else {
                $tasks = Task::orderBy('task_priority', 'asc')
                    ->whereIn('id', $tasksids)->where('task_category_id', $request->id)
                    ->orWhere('task_category_id_two', $request->id)->whereIn('id', $tasksids)
                    ->get();
                $data = view('admin.tasks.filter_by_category', compact('tasks'))->render();
                return response()->json(['options' => $data]);
            }

        } else if ($request->type == "tag" && isset($request->type)) {
            session()->put('tagg_id', $request->id);
            $status = $request->status;
            $tasksids2 = TaskTag::where('tag_id', $request->id)->pluck('task_id');
            //  dd($catids2);

            if ($status == 1) {

                if (!empty($tasksids) && count($tasksids) > 0) {
                    $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 1)
                        ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 1)
                        ->orWhereIn('id', $tasksids2)->whereIn('id', $tasksids)->where('task_status', 1)->get();
                } else {
                    $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 1)
                        ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 1)->get();
                }
            } else if ($status == 2) {

                if (!empty($tasksids) && count($tasksids) > 0) {
                    $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 2)
                        ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 2)
                        ->orWhereIn('id', $tasksids2)->whereIn('id', $tasksids)->where('task_status', 1)->get();
                } else {
                    $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 2)
                        ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 2)->get();
                }

            } else {

                if (!empty($tasksids) && count($tasksids) > 0) {
                    $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 0)
                        ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                        ->orWhereIn('id', $tasksids2)->whereIn('id', $tasksids)->where('task_status', 1)->get();
                } else {
                    $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 0)
                        ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 0)->get();
                }
            }
            $data = view('admin.tasks.filter_by_category', compact('tasks'))->render();
            return response()->json(['options' => $data]);


        } else if ($request->type == "user" && isset($request->type)) {
            session()->forget('catt_id');
            session()->forget('tagg_id');
            if (!empty($request->id)) {
                $status = $request->status;
                $tasksids = TaskTeam::where('user_id', $request->id)->pluck('task_id');

                if ($status == 1) {

                    $tasks = Task::whereIn('id', $tasksids)->where('task_status', 1)
                        ->Orwhere('task_added_by', $request->id)->where('task_status', 1)
                        ->Orwhere('task_responsible', $request->id)->where('task_status', 1)
                        ->orderBy('task_priority', 'asc')->get();

                } else if ($status == 2) {
                    $tasks = Task::whereIn('id', $tasksids)->where('task_status', 2)
                        ->Orwhere('task_added_by', $request->id)->where('task_status', 2)
                        ->Orwhere('task_responsible', $request->id)->where('task_status', 2)
                        ->orderBy('task_priority', 'asc')->get();

                } else {
                    $tasks = Task::whereIn('id', $tasksids)->where('task_status', 0)
                        ->Orwhere('task_added_by', $request->id)->where('task_status', 0)
                        ->Orwhere('task_responsible', $request->id)->where('task_status', 0)
                        ->orderBy('task_priority', 'asc')->get();
                }
                //  $tasks = Task::where('task_category_id',$request->id)->where('task_status' , 0)->orderBy('task_priority' , 'asc')->get();
                $data = view('admin.tasks.filter_by_category', compact('tasks'))->render();
                return response()->json(['options' => $data]);

            }
        } else {


            if (!empty($request->id)) {
                $status = $request->status;
                if ($request->id == "all") {
                    session()->forget('catt_id');
                    session()->forget('tagg_id');
                    if ($status == 1) {

                        if (!empty($tasksids) && count($tasksids) > 0) {
                            $tasks = Task::orderBy('task_priority', 'asc')->whereIn('id', $tasksids)->Orwhere('task_added_by', auth()->user()->id)->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 1)->get();
                        } else {
                            $tasks = Task::orderBy('task_priority', 'asc')->where('task_added_by', auth()->user()->id)->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 1)->get();
                        }

                    } else if ($status == 2) {
                        if (!empty($tasksids) && count($tasksids) > 0) {
                            $tasks = Task::orderBy('task_priority', 'asc')->whereIn('id', $tasksids)->Orwhere('task_added_by', auth()->user()->id)->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 2)->get();
                        } else {
                            $tasks = Task::orderBy('task_priority', 'asc')->where('task_added_by', auth()->user()->id)->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 2)->get();
                        }

                    } else {
                        if (!empty($tasksids) && count($tasksids) > 0) {
                            $tasks = Task::orderBy('task_priority', 'asc')->whereIn('id', $tasksids)->Orwhere('task_added_by', auth()->user()->id)->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 0)->get();
                        } else {
                            $tasks = Task::orderBy('task_priority', 'asc')->where('task_added_by', auth()->user()->id)->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 0)->get();
                        }
                    }
                    $data = view('admin.tasks.filter_by_category2', compact('tasks'))->render();
                    return response()->json(['options' => $data]);
                } else {
                    session()->put('catt_id', $request->id);
                    session()->forget('tagg_id');
                    if ($status == 1) {

                        if (!empty($tasksids) && count($tasksids) > 0) {
                            $tasks = Task::where('task_category_id', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 1)
                                ->Orwhere('task_category_id', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 1)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 1)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 1)
                                ->Orwhere('task_category_id', $request->id)->whereIn('id', $tasksids)->where('task_status', 1)
                                ->Orwhere('task_category_id_two', $request->id)->whereIn('id', $tasksids)->where('task_status', 1)->get();
                        } else {
                            $tasks = Task::where('task_category_id', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 1)
                                ->Orwhere('task_category_id', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 1)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 1)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 1)->get();
                        }
                    } else if ($status == 2) {

                        if (!empty($tasksids) && count($tasksids) > 0) {
                            $tasks = Task::where('task_category_id', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 2)
                                ->Orwhere('task_category_id', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 2)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 2)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 2)
                                ->Orwhere('task_category_id', $request->id)->whereIn('id', $tasksids)->where('task_status', 2)
                                ->Orwhere('task_category_id_two', $request->id)->whereIn('id', $tasksids)->where('task_status', 2)->get();
                        } else {
                            $tasks = Task::where('task_category_id', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 2)
                                ->Orwhere('task_category_id', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 2)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 2)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 2)->get();
                        }

                    } else {
                        if (!empty($tasksids) && count($tasksids) > 0) {
                            $tasks = Task::where('task_category_id', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 0)
                                ->Orwhere('task_category_id', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 0)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                                ->Orwhere('task_category_id', $request->id)->whereIn('id', $tasksids)->where('task_status', 0)
                                ->Orwhere('task_category_id_two', $request->id)->whereIn('id', $tasksids)->where('task_status', 0)->get();
                        } else {
                            $tasks = Task::where('task_category_id', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 0)
                                ->Orwhere('task_category_id', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_added_by', auth()->user()->id)->where('task_status', 0)
                                ->OrWhere('task_category_id_two', $request->id)->where('task_responsible', auth()->user()->id)->where('task_status', 0)->get();
                        }
                    }
                    //  $tasks = Task::where('task_category_id',$request->id)->where('task_status' , 0)->orderBy('task_priority' , 'asc')->get();
                    $data = view('admin.tasks.filter_by_category', compact('tasks'))->render();
                    return response()->json(['options' => $data]);
                }


            }

        }
    }


    public function getAllLogs()
    {
        $logs = Log::orderBy('id', 'desc')->get();
        $status = 3;
        return view('admin.all_logs', compact('logs', 'status'));
    }

    public function getCatTags(Request $request)
    {
        $cat = Category::where('id', $request->cat_id)->first();
        // $tasksids = Task::where('task_category_id' , $request->cat_id)->Orwhere('task_category_id_two',$request->cat_id)->pluck('id');
        // $tagsids = TaskTag::whereIn('task_id',$tasksids)->pluck('tag_id');
        $tags = Tag::where('cat_id', $request->cat_id)->get();
        $status = $request->status;
        $data = view('admin.categories.cat_tags', compact('tags', 'cat', 'status'))->render();
        return response()->json(['options' => $data]);
    }

    public function AllAcounts()
    {
        $datas = User::where('deleted', 0)->where('role', 4)->orderBy('id', 'desc')->get();
        $status = 3;
        return view('admin.accounts.index', compact('datas', 'status'));
    }


    public function AllUsers()
    {
        $datas = User::orderBy('id', 'desc')->where('account_id', auth()->user()->account_id)->where('deleted', 0)->get();
        $status = 3;
        return view('admin.users.index', compact('datas', 'status'));
    }

    public function change_user_status(Request $request)
    {
        $data = $request->all();
        if (!empty($data)) {
            if ($data['user_status'] == 0) {
                User::where('id', $data['user_id'])->update(['status' => 1]);
            } else {
                User::where('id', $data['user_id'])->update(['status' => 0]);
            }
        }
    }

    public function getUsersPiriority()
    {
        $users = User::orderBy('user_piriority', 'desc')->where('account_id', auth()->user()->account_id)->where('status' , 0)->where('deleted', 0)->get();
        $status = 3;
        return view('admin.users.users_piriority', compact('users', 'status'));
    }

    public function updateUserPriority(Request $request)
    {
        try {

            $users_priority = $request->input('data');
            foreach ($users_priority as $user) {
                $id = $user['name'];
                $user_exist = User::find($id);
                if ($user_exist) {
                    $user_exist->user_piriority = $user['value'];
                    $user_exist->save();
                }
            }
            return response()->json(['success' => 'priority update']);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'something went wrong']);

        }
    }

    public function settings()
    {
        return view('admin.settings.index');
    }

    public function deleteModule(Request $request)
    {
        $data = $request->all();
        if (!empty($data['module_name']) && !empty($data['start']) && !empty($data['end'])) {
            $start = Carbon::createFromFormat('d M, Y', $data['start'])->format('Y-m-d');
            $end = Carbon::createFromFormat('d M, Y', $data['end'])->format('Y-m-d');
            if ($data['module_name'] == 'posts') {

                $tasks = Task::with('comments', 'comments.replays', 'subtasks')->whereBetween('created_at', [$start, $end])->get();

                foreach ($tasks as $task) {
                    if (!empty($task->comments)) {
                        foreach ($task->comments as $comment) {
                            if (!empty($comment->replays)) {
                                foreach ($comment->replays as $replay) {
                                    $replay->delete();
                                }
                            }
                        }
                    }
                    if (!empty($task->comments)) {
                        foreach ($task->comments as $comment) {
                            $comment->delete();
                        }
                    }

                    if (!empty($task->subtasks)) {
                        foreach ($task->subtasks as $subtask) {
                            $subtask->delete();
                        }
                    }
                    $task->delete() ;
                }

                return redirect()->back()->with('success', 'Tasks (with Comments , Replays , subtasks  ) Deleted Successfuly');

            } else if ($data['module_name'] == 'comments') {
                $comments = Comment::with('replays')->whereBetween('created_at', [$start, $end])->get();
                if(!empty($comments)) {
                    foreach ($comments as  $comment) {
                        if (!empty($comment->replays)) {
                            foreach ($comment->replays as $replay) {
                                $replay->delete();
                            }
                        }
                        $comment->delete() ;
                    }
                }
                return redirect()->back()->with('success', 'Comments ( With Replays)  Deleted Successfuly');

            } else if ($data['module_name'] == 'subtasks') {

                $subtasks  = SubTask::whereBetween('created_at', [$start, $end])->get();
                if(!empty($subtasks))
                {
                    foreach($subtasks as $subtask)
                    {
                        $subtask->delete();
                    }
                }
                return redirect()->back()->with('success', 'Subtasks  Deleted Successfuly');

            } else if ($data['module_name'] == 'tags') {

               $tags =  Tag::whereBetween('created_at', [$start, $end])->get();
                if(!empty($tags)) {
                    foreach ($tags as  $tag) {
                        if (!empty($tag->categories)) {
                            foreach ($tag->categories  as $category) {
                                $category->delete();
                            }
                        }
                        $tag->delete() ;
                    }
                }

                return redirect()->back()->with('success', 'Tags (with Categories ) Deleted Successfuly');
            }
        }

    }


}
