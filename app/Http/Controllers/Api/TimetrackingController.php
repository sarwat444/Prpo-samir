<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimeTracking\TimeTrackingResource;
use App\Models\Category;
use App\Models\SubTask;
use App\Models\TaskGuest;
use App\Models\TaskHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\CustomResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TimetrackingController extends Controller
{

    protected $response;

    /**
     * @param $response
     */
    public function __construct(CustomResponse $response)
    {
        $this->response = $response;
    }

    public function index(): JsonResponse
    {
        $user = Auth::user();
        $subtasks = TimeTrackingResource::collection(SubTask::where('subtask_user_id', $user->id)
            ->whereHas('history')
            ->with(['history' => function ($query) {
                $query->orderBy('created_at', 'DESC');
            }])->withSum('history', 'time')
            ->with('task.category')
            ->with('added_by')
            ->orderBy('id', 'DESC')
            ->get());

        return response()->json([
            'subtasks' => $subtasks,
            'status' => true
        ], Response::HTTP_OK);
    }

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

