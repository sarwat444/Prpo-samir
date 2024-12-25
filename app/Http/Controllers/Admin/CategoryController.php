<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;
use App\Models\Log;
use App\Models\Tag;
use App\Models\TaskTeam;
use App\Models\SubTask;
use App\Models\User;
use App\Models\TaskGuest;
use App\Models\TaskTag;
use DataTables;
use DB;
use PHPUnit\Exception;
use Validator;
use Auth;
use function Couchbase\defaultDecoder;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{

    public function index()
    {
        $subtasks = SubTask::where('timer', 1)->where('account_id', auth()->user()->account_id)->get();
        $today_subtasks = SubTask::whereDate('created_at', DB::raw('CURDATE()'))->where('timer', 0)->where('account_id', auth()->user()->account_id)->with('responsible')->get();
        $status = 3;
        return view('admin.dashboard.index', compact('subtasks','today_subtasks', 'status'));

    }
    public function crm()
    {
        $subtasks = SubTask::where('timer', 1)->where('account_id', auth()->user()->account_id)->get();
        $today_subtasks = SubTask::whereDate('created_at', DB::raw('CURDATE()'))->where('timer', 0)->where('account_id', auth()->user()->account_id)->with('responsible')->get();
       //Counts
        $category_count  = Category::where('account_id', auth()->user()->account_id)->count();
        $package_count  = Package::count();
        $user_count  = User::where('account_id', auth()->user()->account_id)->count();
        $status = 3;

        return view('admin.dashboard.index', compact('subtasks','today_subtasks', 'category_count','package_count' , 'user_count', 'status'));

    }
    public function allCategories()
    {
        $categories = Category::where('account_id', auth()->user()->account_id)->orderBy('priority', 'desc')->get();
        $status = 3;
        return view('admin.categories.list_categories', compact('categories'));
    }

    public function updatePriority(Request $request)
    {
        try {
            foreach ($request->cat_priority as $key => $value) {
                $cat = Category::find($key);
                if ($cat) {
                    $cat->priority = (int)$value;
                    $cat->category_color= $request->color[$key];
                    $cat->save();
                }
            }
            return back()->with(['success' => 'Priorität der Kategorien aktualisiert']);
        } catch (Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);

        }
    }

    public function listTagModal(Request $request)
    {
        $tags = Tag::where('cat_id', $request->id)->get();
        if (!$tags) {
            return response()->json(['error' => 'tag not found']);
        }

        $view = view('front.models.edit_categories_tags', compact('tags'))->render();
        return response()->json(['html' => $view]);
    }

    public function updateCategoryTagsModal(Request $request)
    {
        try {
            $keys = $request->keys;
            $names = $request->name;
            $priorities = $request->priority;
            foreach ($keys as $key) {
                $tag = Tag::find($key);

                if ((isset($priorities[$key])) && (isset($names[$key]))) {
                    $tag->tag_name = $names[$key];
                    $tag->priority = $priorities[$key];
                    $tag->save();
                }
            }
            return response()->json(['success' => 'Priorität der Kategorien aktualisiert']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

    }


    public function copySubTaskAjax(Request $request)
    {
        $id = $request->id;
        $tasks = Task::all();
        $cat_id = $request->cat_id;
        if ($request->cat_id) {
            $tasks = Task::where('task_category_id', $request->cat_id)->get();
        }
        $subtask = SubTask::find($id);

        if (!$subtask) {
            return response()->json(['error' => 'subtask not found']);
        }
        $categories = Category::where('account_id', auth()->user()->account_id)->orderBy('id', 'desc')->get();

        $view = view('front.models.copy_subtask', compact('categories', 'tasks', 'subtask', 'cat_id'))->render();

        return response()->json(['html' => $view, 'tasks' => $tasks]);
    }


    public function cutSubTaskAjax(Request $request)
    {
        $id = $request->id;
        $tasks = Task::all();
        $cat_id = $request->cat_id;
        if ($request->cat_id) {
            $tasks = Task::where('task_category_id', $request->cat_id)->get();
        }
        $subtask = SubTask::find($id);
        if (!$subtask) {
            return response()->json(['error' => 'subtask not found']);
        }
        $categories = Category::where('account_id', auth()->user()->account_id)->orderBy('id', 'desc')->get();

        $view = view('front.models.cut_subtask', compact('categories', 'tasks', 'subtask', 'cat_id'))->render();
        return response()->json(['html' => $view, 'tasks' => $tasks]);
    }

    public function postSubTaskAjax(Request $request)
    {
        try {
            $subtask_id = $request->id;
            $subtask = SubTask::find($subtask_id);


            if ($subtask) {
                $task = Task::create([
                    'task_title' => $subtask->subtask_title,
                    'task_description' => $subtask->subtask_title,
                    'task_category_id' => $subtask->task->task_category_id,
                    'task_category_id_two' => $subtask->task->task_category_id_two,
                    'task_added_by' => Auth::user()->id,
                    'task_responsible' => $subtask->subtask_added_by,
                    'account_id' => $subtask->account_id,
                    'task_priority' => $subtask->task->task_priority,
                    'under_categorie' => $subtask->task->under_categorie,
                    'task_status' => $subtask->task->task_status,
                    'task_due_date' => $subtask->task->task_due_date,
                    'task_start_date' => $subtask->task->task_start_date,
                ]);
                $team = $subtask->task->team;
                foreach ($team as $member) {
                    TaskTeam::create([
                        'task_id' => $task->id,
                        'user_id' => $member->user_id,
                        'account_id' => $subtask->account_id
                    ]);
                }
                if ($request->subtask_delete == true) {
                    $subtask->delete();
                }

                return response()->json(['success' => 'Teilaufgabe Erfolgreich gepostet']);
            }

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);

        }
    }

    public function edit_category_modal(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        try {
            $category = Category::find($request->id);
            if (empty($category)) {
                return response()->json([
                    'error' => 'Category not found'
                ]);
            }
            $view = view('front.models.edit_category', compact('category'))->render();
            return response()->json([
                'html' => $view
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function category_update_modal(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'priority' => 'required'
        ]);
        try {
            $id = decrypt($request->id);
            $category = Category::find($id);
            if (empty($category)) {
                return response()->json(['error' => 'category not found']);
            }
            $category->category_name = $request->name;
            $category->priority = $request->priority;
            $category->category_color  = $request->category_color  ;
            $category->save();
            return response()->json(['success' => 'category updated']);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);

        }

    }


    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_name' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z0-9\s]+$/', // Allows only letters, numbers, and spaces
                    Rule::unique('categories')->where(fn ($query) => $query->whereNull('deleted_at')),
                ],
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with(array('errors' => $validator->getMessageBag()));
            }

            DB::beginTransaction();

            $data = new Category();
            $data->category_name = $request->category_name;
            $data->category_color = $request->category_color;
            $data->account_id = auth()->user()->account_id;
            $data->save();

            $log = new Log();
            $log->log_desc = "The User " . Auth::user()->user_name . ' Add A New Kategorie ' . $data->category_name;
            $log->log_user_id = Auth::user()->id;
            $log->log_cat_id = $data->id;
            $log->account_id = auth()->user()->account_id;
            $log->save();
            DB::commit();

            return redirect()->route('admin.categories.create')->with(['success' => 'Data Added Successfully']);
        } catch (Exception $e) {
            return redirect()->route('admin.categories.create')->with(['error' => 'Something Wrong Happen']);
        }


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);
        return view('admin.categories.edit', ['category' => $category, 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_name' => 'required|string|unique:categories,category_name,' . $id,
            ]);

            if ($validator->fails()) {
                return redirect()->route('admin.categories.edit')->with(array('errors' => $validator->getMessageBag()));
            }
            DB::beginTransaction();
            $data = Category::find($id);
            $data->category_name = $request->category_name;
            $data->category_color = $request->category_color;
            $data->save();
            $log = new Log();
            $log->log_desc = "The User " . Auth::user()->user_name . ' Updated The Kategorie ' . $data->category_name;
            $log->log_user_id = Auth::user()->id;
            $log->log_cat_id = $id;
            $log->account_id = auth()->user()->account_id;
            $log->save();
            DB::commit();
            return redirect()->route('admin.categories')->with(['success' => 'Data Updated Successfully']);
        } catch (Exception $e) {
            return redirect()->route('admin.categories')->with(['error' => 'Something Wrong Happen']);
        }

    }

    public function deleteCategory(Request $request)
    {
        $id = $request->id;

        // Check if the category has tasks
        if ($this->showtaskcount($id)) {
            // Redirect to deletewithtasks function if tasks exist
            return $this->deletewithtasks($request);
        } else {
            // Redirect to deletenotasks function if no tasks exist
            return $this->deletenotasks($request);
        }
    }

    public function showtaskcount(Request $request)
    {
        $id = $request->id;

        // Count the tasks related to the category
        $taskCount = Task::where('task_category_id', $id)->count();

        return response()->json([
            'status' => $taskCount > 0, // True if tasks exist, false otherwise
            'task_count' => $taskCount, // Number of tasks
        ]);
    }

    public function deletewithtasks(Request $request)
    {
        $id = $request->id;

        // Fetch all tasks related to the category
        $tasks = Task::where('task_category_id', $id)->get();

        if ($tasks->count() > 0) {
            if ($request->has('delete_with_tasks') && $request->delete_with_tasks) {
                // Soft delete all tasks related to the category
                Task::where('task_category_id', $id)->delete();

                $category = Category::find($id);
                if ($category) {
                    // Log the deletion action
                    $log = new Log();
                    $log->log_desc = "The User " . Auth::user()->user_name . ' deleted the category and its tasks: ' . $category->category_name;
                    $log->log_user_id = Auth::user()->id;
                    $log->log_cat_id = $id;
                    $log->account_id = auth()->user()->account_id;
                    $category->delete(); // Soft delete the category
                    $log->save();

                    // Respond with success message
                    return response()->json([
                        "status" => true,
                        "msg" => 'Category and all its tasks deleted successfully'
                    ], 200);
                }
            } else {
                // Inform the user that they need to confirm task deletion
                return response()->json([
                    "status" => false,
                    "msg" => 'This category has ' . $tasks->count() . ' tasks. Deleting this category will also delete all associated tasks. Please confirm deletion.',
                    "task_count" => $tasks->count()
                ], 200);
            }
        }
    }

    public function deletenotasks(Request $request)
    {
        $id = $request->id;
        $category = Category::find($id);

        if ($category) {
            // Log the deletion of the category
            $log = new Log();
            $log->log_desc = "The User " . Auth::user()->user_name . ' deleted the category: ' . $category->category_name;
            $log->log_user_id = Auth::user()->id;
            $log->log_cat_id = $id;
            $log->account_id = auth()->user()->account_id;
            $category->delete(); // Soft delete the category
            $log->save();

            // Respond with success message
            return response()->json([
                "status" => true,
                "msg" => 'Category deleted successfully'
            ], 200);
        } else {
            // Category not found
            return response()->json([
                "status" => false,
                "msg" => 'Category not found'
            ], 404);
        }
    }


    public function addTag(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tag_name' => [
                    'required',
                    'string',
                    'regex:/^[a-zA-Z0-9\s]+$/', // Allows only letters, numbers, and spaces
                ],
                'cat_id' => 'required|array|min:1', // Ensures at least one category is selected
            ]);


            if ($validator->fails()) {
                return redirect()->route('admin.dashboard')->withErrors($validator)->withInput();
            }

            $tagcats = $request->input('cat_id');
            $tagExists = Tag::where('tag_name', $request->tag_name)->exists();

            if ($tagExists) {
                return redirect()->route('admin.dashboard')->with('error', 'Tag is already found and has posts. If you want to add posts to it, update the tag.');
            }

            foreach ($tagcats as $catId) {
                Tag::create([
                    'tag_name' => $request->tag_name,
                    'cat_id' => $catId,
                    'account_id' => auth()->user()->account_id,
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Record added successfully!');
        } catch (Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function allTasks(Request $request, $cat_id, $status)
    {

        $search_key = '';
        if ($request->has('search_name')) {
            $search_key = $request->search_name;
        }
        $tags_ids=[];
        $category = Category::where('id', $cat_id)
            ->whereNull('deleted_at')
            ->first();
        if(!empty($category) || $cat_id == 0) {
            if ($cat_id != 0) {
                $cat_tasks = Category::find($cat_id)->tasks;
                $tasks_cats_ids = $cat_tasks->pluck('id');
                $task_tags = TaskTag::whereIn('task_id', $tasks_cats_ids)->get();
                $tags_ids = $task_tags->unique('tag_id')->pluck('tag_id');
            }
            session()->put('catt_id', $cat_id);

            $tags = Tag::where('cat_id', $cat_id)->orderBy('priority', 'desc')->get();
            //$tags = Tag::whereIn('id', $tags_ids)->orderBy('priority', 'desc')->get();
            $categories = Category::where('account_id', auth()->user()->account_id)->orderBy('priority', 'desc')->get();
            $tasksids = \App\Models\TaskTeam::where('account_id', auth()->user()->account_id)->where('user_id', auth()->user()->id)->pluck('task_id');

            if ($cat_id == 0) {

                if ($status == 1) {
                    $title = 'Pripo Completed';
                    if (auth()->user()->role == 1) {
                        $tasks = Task::where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')->get();
                    } else {
                        $tasks = Task::where('task_added_by', auth()->user()->id)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->OrWhere('task_added_by', auth()->user()->id)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->OrWhere('task_responsible', auth()->user()->id)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->orWhereIn('id', $tasksids)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->orWhereIn('id', $tasksids)->where('task_status', 1)->orderBy('task_priority', 'asc')->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->get();
                    }
                } else if ($status == 2) {
                    $title = 'Pripo Deleted';
                    if (auth()->user()->role == 1) {
                        $tasks = Task::where('task_status', 2)->get();
                    } else {
                        $tasks = Task::where('task_added_by', auth()->user()->id)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->Orwhere('task_responsible', auth()->user()->id)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->OrWhere('task_added_by', auth()->user()->id)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->OrWhere('task_responsible', auth()->user()->id)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->orWhereIn('id', $tasksids)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->orWhereIn('id', $tasksids)->where('task_status', 2)->orderBy('task_priority', 'asc')->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->get();
                    }
                } else {


                    //all tasks  on 0 / 0
                    $title = 'Pripo';
                    if (auth()->user()->role == 1) {

                        $tasks = Task::where('task_status', 0)
                            ->where('task_title', 'LIKE', '%' . $search_key . '%')->orderBy('task_priority', 'asc')->get();
                    } else {
                        $tasks = Task::WhereIn('id', $tasksids)->where('task_status', $status)->orderBy('task_priority', 'asc')->where('task_title', 'LIKE', '%' . $search_key . '%')
                            ->get();
                    }

                }

            } else {

                if ($status == 1) {
                    $title = 'Pripo Completed';
                    $tasks = Task::where('task_title', 'LIKE', '%' . $search_key . '%')->where('task_category_id', $cat_id)->where('task_added_by', auth()->user()->id)->where('task_status', 1)
                        ->Orwhere('task_category_id', $cat_id)->where('task_responsible', auth()->user()->id)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->OrWhere('task_category_id_two', $cat_id)->where('task_added_by', auth()->user()->id)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->OrWhere('task_category_id_two', $cat_id)->where('task_responsible', auth()->user()->id)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->Orwhere('task_category_id', $cat_id)->whereIn('id', $tasksids)->where('task_status', 1)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->Orwhere('task_category_id_two', $cat_id)->whereIn('id', $tasksids)->where('task_status', 1)->orderBy('task_priority', 'asc')->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->get();
                } else if ($status == 2) {
                    $title = 'Pripo Deleted';
                    $tasks = Task::where('task_title', 'LIKE', '%' . $search_key . '%')->where('task_category_id', $cat_id)->where('task_added_by', auth()->user()->id)->where('task_status', 2)
                        ->Orwhere('task_category_id', $cat_id)->where('task_responsible', auth()->user()->id)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->OrWhere('task_category_id_two', $cat_id)->where('task_added_by', auth()->user()->id)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->OrWhere('task_category_id_two', $cat_id)->where('task_responsible', auth()->user()->id)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->Orwhere('task_category_id', $cat_id)->whereIn('id', $tasksids)->where('task_status', 2)->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->Orwhere('task_category_id_two', $cat_id)->whereIn('id', $tasksids)->where('task_status', 2)->orderBy('task_priority', 'asc')->where('task_title', 'LIKE', '%' . $search_key . '%')
                        ->get();
                } else {
                    $title = 'Pripo';
                    // Category content if status is equal 0 ..
                    if (auth::user()->role == 1) {
                        $tasks = Task::where('task_status', 0)
                            ->where(function ($query) use ($cat_id, $search_key) {
                                $query->where('task_category_id', $cat_id)
                                    ->where('task_title', 'LIKE', '%' . $search_key . '%')
                                    ->orWhere('task_category_id_two', $cat_id)
                                    ->where('task_title', 'LIKE', '%' . $search_key . '%');
                            })
                            ->orderBy('task_priority', 'asc')
                            ->get();
                    } else {
                        $tasks = Task::where('task_category_id', $cat_id)->where('task_status', 0)->where('task_title', 'LIKE', '%' . $search_key . '%')->where('task_added_by', auth()->user()->id)
                            ->OrWhere('task_category_id', $cat_id)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                            ->Orwhere('task_category_id', $cat_id)->whereIn('id', $tasksids)->where('task_status', 0)->get();

                    }

                }
            }

            return view('admin.categories.all_tasks', compact('tasks', 'tags', 'categories', 'title', 'status', 'cat_id'));
        }else
        {
            return  redirect()->route('admin.dashboard')->with('error','This category is deleted') ;
        }
    }

    public function allCatTagTasks($cat_id, $tag_id, $status)
    {

        $cat_tasks = Category::find($cat_id)->tasks;
        $tasks_cats_ids = $cat_tasks->pluck('id');
        $task_tags = TaskTag::whereIn('task_id', $tasks_cats_ids)->get();
        $tags_ids = $task_tags->unique('tag_id')->pluck('tag_id');
        $tags = Tag::whereIn('id', $tags_ids)->orderBy('priority', 'desc')->get();
        $categories = Category::where('account_id', auth()->user()->account_id)->orderBy('priority', 'desc')->get();
        $tasksids = \App\Models\TaskTeam::where('account_id', auth()->user()->account_id)->where('user_id', auth()->user()->id)->pluck('task_id');
        $tasksids2 = TaskTag::where('tag_id', $tag_id)->pluck('task_id');
        foreach ($tasksids2 as $key => $task){
            $t = Task::where('id',$task)->first();
            if ($t->task_category_id !=$cat_id  ){
                $tasksids2->forget($key);
}
    }
        session()->put('catt_id', $cat_id);
        session()->put('tagg_id', $tag_id);
        if ($status == 1) {
            $title = 'Pripo Completed';
            if (!empty($tasksids) && count($tasksids) > 0) {
                $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 1)->where('task_category_id', $cat_id)
                    ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 1)
                    ->orWhereIn('id', $tasksids2)->whereIn('id', $tasksids)->where('task_status', 1)->orderBy('task_priority', 'asc')->get();
            } else {
                $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 1)->where('task_category_id', $cat_id)
                    ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 1)->orderBy('task_priority', 'asc')->get();
            }
        } else if ($status == 2) {
            $title = 'Pripo Deleted';
            if (!empty($tasksids) && count($tasksids) > 0) {
                $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 2)->where('task_category_id', $cat_id)
                    ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 2)
                    ->orWhereIn('id', $tasksids2)->whereIn('id', $tasksids)->where('task_status', 1)->orderBy('task_priority', 'asc')->get();
            } else {
                $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 2)->where('task_category_id', $cat_id)
                    ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 2)->orderBy('task_priority', 'asc')->get();
            }

        } else {
            $title = 'Pripo';

            if (!empty($tasksids) && count($tasksids) > 0) {
                $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 0)->where('task_category_id', $cat_id)
                    ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 0)
                    ->orWhereIn('id', $tasksids2)->whereIn('id', $tasksids)->where('task_status', 0)->orderBy('task_priority', 'asc')->get();
            } else {
                $tasks = Task::whereIn('id', $tasksids2)->where('task_added_by', auth()->user()->id)->where('task_status', 0)->where('task_category_id', $cat_id)
                    ->orWhereIn('id', $tasksids2)->where('task_responsible', auth()->user()->id)->where('task_status', 0)->orderBy('task_priority', 'asc')->get();
            }
        }
        return view('admin.categories.all_cat_tag_tasks', compact('tasks', 'tags', 'categories', 'title', 'status', 'cat_id', 'tag_id'));
    }

    public function getCategoryTag(Request $request )
    {
       /*
        $data  = $request->all() ;
        $tags = Tag::where('cat_id', $data['category_id'])->orderBy('priority', 'desc')->get();
        $options="";
        if(!empty($tags)){
            foreach ($tags as $key => $tag) {
                $options .= "<option id ='$key' value='$tag->id'> $tag->tag_name </option >" ;
             }
          return  $options ;

        }
       */
    }

}
