<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\CustomResponse;
use App\Models\Category;
use App\Models\Task;
use App\Models\Tag;
use App\Models\Log;
use App\Models\TaskTag;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;


class CategoryController extends Controller
{
    protected $response;

    /**
     * @param $response
     */

    public function __construct(CustomResponse $response)
    {
        $this->response = $response;
    }




    public function index($id = null): JsonResponse
    {
        try {

            $user = Auth::user();
            if(!empty($id)) {
                $categories = Category::where('id',$id)->where('account_id', $user->account_id)->orderBy('priority', 'desc')->get();
            }else {
                $categories = Category::where('account_id', $user->account_id)->orderBy('priority', 'desc')->get();
            }
            return response()->json([
                'categories' => $categories,
                'status' => true
            ]);
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

   public function tasks(Request $request, $category_id = null ,$type = null): JsonResponse
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
                        ->with('added_by' , 'team.user' ,'category' ,'second_category' )
                        ->withCount('un_completed_subtasks' , 'completed_subtasks')
                        ->when(request()->has('title'), function ($query) {
                            return $query->where('task_title', 'Like', '%' . request()->input('title') . '%');
                        })->orderBy('task_priority' , 'asc')
                        ->get();

                }else
                {
                    $tasks = Task::where('task_category_id', $category_id)->where('task_status', 0)->where('task_added_by', auth()->user()->id)->when(request()->has('title'), function ($query) {
                        return $query->where('task_title', 'Like', '%' . request()->input('title') . '%');
                    })
                        ->with('added_by' , 'team.user' ,'category' ,'second_category')
                        ->withCount('un_completed_subtasks' , 'completed_subtasks')
                        ->OrWhere('task_category_id', $category_id)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                        ->Orwhere('task_category_id', $category_id)->whereIn('id', $tasksids)->where('task_status', 0)->when(request()->has('title'), function ($query) {
                            return $query->where('task_title', 'Like', '%' . request()->input('title') . '%');
                        })->orderBy('task_priority' , 'asc')
                        ->get();
                }


                return response()->json([
                    'message' => 'pending Tasks with Cateogry' ,
                    'tasks' => $tasks,
                    'status' => true
                ], Response::HTTP_OK);


            } else {
                if (auth()->user()->role == 1) {
                    $tasks = Task::where('task_status', 0) ->with('added_by' , 'team.user' ,'category' ,'second_category')->withCount('un_completed_subtasks' , 'completed_subtasks')->when(request()->has('title'), function ($query) {
                        return $query->where('task_title', 'Like', '%' . request()->input('title') . '%');
                    })->orderBy('task_priority' , 'asc')->get();
                } else {
                    $tasks = Task::WhereIn('id', $tasksids)->where('task_status', 0)->with('added_by' , 'team.user' ,'category' ,'second_category')->withCount('un_completed_subtasks' , 'completed_subtasks')->orderBy('task_priority', 'asc') ->when(request()->has('title'), function ($query) {
                        return $query->where('task_title', 'Like', '%' . request()->input('title') . '%');
                    })->get();
                }

                return response()->json([
                    'message' => 'pending Tasks' ,
                    'tasks' => $tasks,
                    'status' => true
                ], Response::HTTP_OK);

            } //end fillter pending

            $tasks = $tasks->withCount(['completed_subtasks', 'un_completed_subtasks']);
            $tasks = $tasks->get();
            return response()->json([
                'tasks' => $tasks,
                'status' => true
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }
    public function tagTasks($id, $tag_id): JsonResponse
    {
        try {
            $cat_tasks = Category::findOrFail($id)->tasks;
            $tasks_cats_ids = $cat_tasks->pluck('id');
            $task_tags = TaskTag::whereIn('task_id', $tasks_cats_ids)->get();
            $tags_ids = $task_tags->unique('tag_id')->pluck('tag_id');
            $tags = Tag::whereIn('id', $tags_ids)->orderBy('priority', 'desc')->get();
            $categories = Category::where('account_id', auth()->user()->account_id)->orderBy('priority', 'desc')->get();
            $tasksids = \App\Models\TaskTeam::where('account_id', auth()->user()->account_id)->where('user_id', auth()->user()->id)->pluck('task_id');
            $tasksids2 = TaskTag::where('tag_id', $tag_id)->pluck('task_id');
            foreach ($tasksids2 as $key => $task) {
                $t = Task::where('id', $task)->first();
                if ($t->task_category_id != $id) {
                    $tasksids2->forget($key);
                }
            }
            $tasks =[];

            if (!empty($tasksids) && count($tasksids) > 0) {
                $tasks = Task::whereIn('id', $tasksids2)
                    ->where('task_added_by', auth()->user()->id)
                    ->where('task_status', 1)
                    ->where('task_category_id', $id)
                    ->orWhereIn('id', $tasksids2)
                    ->where('task_responsible', auth()->user()->id)
                    ->orWhereIn('id', $tasksids2)
                    ->whereIn('id', $tasksids)
                    ->orderBy('task_priority', 'asc')
                    ->get();
            } else {
                $tasks = Task::whereIn('id', $tasksids2)
                    ->where('task_added_by', auth()->user()->id)
                    ->where('task_category_id', $id)
                    ->orWhereIn('id', $tasksids2)
                    ->where('task_responsible', auth()->user()->id)
                    ->orderBy('task_priority', 'asc')
                    ->get();
            }
            return response()->json([
                'tasks' => $tasks,
                'status' =>true
            ]);
        }catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }


    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_color' => 'required',
                'category_name' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }

            DB::beginTransaction();
            $category = Category::create([
                'category_name' => $request->category_name,
                'category_color' => $request->category_color,
                'account_id' => Auth::user()->account_id
            ]);
            $log = new Log();
            $log->log_desc = "The User " . Auth::user()->user_name . ' Add A New Kategorie ' . $request->category_name;
            $log->log_user_id = Auth::user()->id;
            $log->log_cat_id = $category->id;
            $log->account_id = auth()->user()->account_id;
            $log->save();
            DB::commit();
            return response()->json([
                'message' => 'Category created',
                'status' => true
            ], Response::HTTP_CREATED);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->response->internalError($exception);
        }
    }


    public function toggleDelete($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            if ($category->deleted === 1) {
                $category->deleted = 0;
                $category->save();
                return response()->json([
                    'message' => 'undeleted successfuly',
                    'status' => true
                ]);
            }
            $category->deleted = 1;
            $category->save();
            return response()->json([
                'message' => 'deleted successfuly',
                'status' => true
            ]);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }

    }

    public function addTag(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tag_name' => 'required|string',
                'cat_id' => 'required',
            ]);
            if ($validator->fails()) {

                return response()->json([
                    'message' => 'Validation error',
                    'status' => false
                ]);


            }
            DB::beginTransaction();
            $data = new Tag();
            $data->tag_name = $request->tag_name;

            $tagcats = $request->input('cat_id');
            $tagcats = json_decode($tagcats) ;
            if (!empty($tagcats)) {
                for ($i = 0; $i < count($tagcats); $i++) {
                    $data = new Tag();
                    $data->tag_name = $request->tag_name;
                    $data->cat_id = $tagcats[$i];
                    $data->account_id = auth()->user()->account_id;
                    $data->save();
                }
                return response()->json([
                    'message' => 'Tag Added Successfuly',
                    'status' => true ,
                ]);
            }


        } catch (Exception $e) {
            return redirect()->route('admin.dashboard')->with(['error' => 'Something Wrong Happen']);
        }


    }


}
