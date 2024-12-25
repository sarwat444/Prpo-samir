<?php

namespace App\Http\Controllers\Api;

use App\Events\ReplayNotification;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Comment;
use App\Models\User;
use DB;
use App\Models\Replay;
use App\Models\SubTask;
use App\Helpers\CustomResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends Controller
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
        try {
            $comments = Comment::with('user', 'task')->orderBy('id', 'Desc')->get();
            $notes = [];
            foreach ($comments as $comment) {

                if (!empty($comment->tags)) {
                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {

                        $notes[] = $comment;

                    }
                }
            }
            //Send Taged  Replays
            $replays = [];
            $all_replays = Replay::orderBy('id', 'Desc')->get();
            foreach ($all_replays as $replay) {

                if (!empty($replay->tags)) {
                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {

                        $replays[] = $replay;

                    }
                }
            }
            return response()->json([
                'comments' => $notes,
                'replays' => $replays,
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }

    public function destroy($id): JsonResponse
    {
        try {

            $comment = Comment::findOrFail($id);
            if ($comment->comment_added_by !== Auth::user()->id) {
                return response()->json([
                    'message' => ' Unauthorized action',
                    'status' => false
                ], Response::HTTP_UNAUTHORIZED);
            }
            $comment->delete();
            return response()->json([
                'message' => 'comment deleted',
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function updateComment(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Comment::find($request->id);
            $data->comment = $request->comment_name;
            if ($data->comment_added_by !== Auth::user()->id) {
                return response()->json([
                    'message' => ' Unauthorized action',
                    'status' => false
                ], Response::HTTP_UNAUTHORIZED);
            } else {
                $data->save();
                DB::commit();
                return response()->json([
                    'message' => 'comment Updated',
                    'status' => true
                ], Response::HTTP_OK);
            }
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }


    public function find($id): JsonResponse
    {
        try {
            $comment = Comment::findOrFail($id);
            return response()->json([
                'comment' => $comment,
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }

    /* Get Subtask Comments  */
    public function subtaskcomments($id): JsonResponse
    {
        try {
            if (Auth::user()->role_id == 1) {
                $subtask = SubTask::with('added_by')->where('id', $id)->with(['task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image'])->first();
            } else {
                $subtask = SubTask::with('added_by')->where('id', $id)->where('subtask_user_id', Auth::user()->id)->with(['task:id,task_title', 'added_by:id,user_name,image', 'responsible:id,user_name,image'])->first();
            }
            $comments = Comment::with('subtask')->where('subtask_id', $id)->with('user', 'replays')->where('done', '==', 0)->orderBy('id', 'desc')->get();
            foreach ($comments as $comment) {
                $tag_ids = explode(",", $comment->tags);
                $read_by_ids = json_decode($comment->readby);
                $tag_users = User::whereIn('id', $tag_ids)->select('id', 'first_name')->get();
                foreach ($tag_users as $tag_user) {
                    if (!empty($read_by_ids)) {
                        if (!in_array($tag_user->id, $read_by_ids)) {
                            $tag_user->seen = 0;
                        } else {
                            $tag_user->seen = 1;
                        }
                    } else {
                        $tag_user->seen = 0;
                    }
                }
                $comment->tags = $tag_users;
                foreach ($comment->replays as $replay) {
                    $reply_tag_ids = explode(",", $replay->tags);
                    $reply_read_by_ids = json_decode($replay->is_read);
                    $reply_tag_users = User::whereIn('id', $reply_tag_ids)->pluck('first_name');
                    if (!empty($reply_read_by_ids)) {
                        $reply_readby_users = User::whereIn('id', $reply_read_by_ids)->pluck('first_name');
                    } else {
                        $reply_readby_users = [];
                    }
                    $replay->tags = $reply_tag_users;
                    $replay->is_read = $reply_readby_users;
                }

            }
            return response()->json([
                'subtask' => $subtask,
                'comments' => $comments,
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function taggedComments()
    {
        try {
            $comments = Comment::with('user', 'task')->orderBy('id', 'Desc')->get();
            $notes = new \Illuminate\Database\Eloquent\Collection();
            foreach ($comments as $comment) {
                if($comment->is_read == null){
                    $comment->is_read = "[]";
                }
                if (!empty($comment->tags)) {
                    $tags = explode(',', $comment->tags);
                    if (in_array(Auth()->user()->id, $tags)) {
                        $read_by_ids = json_decode($comment->readby);
                        if (!empty($read_by_ids)) {
                            if (!in_array(Auth()->user()->id, $read_by_ids) && $comment->status != 1) {
                                $notes->push($comment);
                            }
                        } else {
                            $comment->is_read = "[]";
                            $notes->push($comment);
                        }
                    }
                }
            }

            $all_replays = Replay::with('user')->get();
            $replays_arr = new \Illuminate\Database\Eloquent\Collection();
            foreach ($all_replays as $replay) {
                if($replay->is_read == null){
                    $replay->is_read = "[]";
                }
                if (!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);
                    if (in_array(Auth()->user()->id, $tags)) {

                        $read_by_ids = json_decode($replay->is_read);
                        if (!empty($read_by_ids)) {
                            if (!in_array(Auth()->user()->id, $read_by_ids)) {
                                $replays_arr->push($replay);
                            }
                        } else {
                            $replays_arr->push($replay);
                        }

                    }
                }
            }
            $allResults = $notes->merge($replays_arr);
            $allResults = $allResults->SortByDesc('created_at');

            $newnotes = array();
            foreach ($allResults as $new) {
                $newnotes[] = $new;
            }

            return response()->json([
                'messages' => 'Default Pending',
                'notes' => $newnotes,
                'status' => true
            ], Response::HTTP_OK);


        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }

    }

    public function seenComment(Request $request): JsonResponse
    {
        try {

            $data = $request->all();
            $readedcomment = Comment::where(['id' => $data['comment_id']])->first();

            if (empty($readedcomment->readby)) {
                $readedcomment->readby = json_encode(array($data['readby']));
                $readedcomment->save();
            } else {
                $users_readed = json_decode($readedcomment->readby);
                if (!in_array($data['readby'], $users_readed)) {
                    if ($request->value == 1) {
                        array_push($users_readed, $data['readby']);
                        $readedcomment->readby = json_encode($users_readed);
                        $readedcomment->save();
                    }

                } else {
                    if ($request->value == 0) {
                        $key = array_search($data['readby'], $users_readed);
                        unset($users_readed[$key]);
                        $readedcomment->readby = array_values($users_readed);
                        $readedcomment->save();
                    }
                }

            }


            $replays = Replay::where('comment_id', $data['comment_id'])->get();

            if (!empty($replays)) {
                foreach ($replays as $replay) {
                    if (empty($replay->is_read) || $replay->is_read == NULL) {
                        $replay->is_read = json_encode(array($data['readby']));
                        $replay->save();

                    } else {
                        $arr = json_decode($replay->is_read);
                        if (!in_array(Auth::user()->id, $arr)) {
                            if ($request->value == 1) {
                                array_push($arr, $data['readby']);
                                $replay->is_read = json_encode($arr);
                                $replay->save();
                            } else {
                                if ($request->value == 0) {
                                    $key = array_search($data['readby'], $arr);
                                    unset($arr[$key]);
                                    $replay->is_read = array_values($arr);
                                    $replay->save();
                                }

                            }
                        } else {
                            if ($request->value == 0) {
                                $key = array_search($data['readby'], $arr);
                                unset($arr[$key]);
                                $replay->is_read = array_values($arr);
                                $replay->save();
                            }
                        }
                    }
                }
                return response()->json([
                    'msg' => 'Comment And Replays Updated Successfuly',
                    'status' => true
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'msg' => 'Comment  Updated Successfuly',
                    'status' => true
                ], Response::HTTP_OK);
            }

            /*End Of update Replays */
        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }

    }

    public function hide($id): JsonResponse
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->status = 1;
            $comment->save();
            return response()->json([
                'message' => ' updated successfully',
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }

    }

    public function reply(Request $request, $id): JsonResponse
    {

        try {
            $validator = Validator::make($request->all(), [
                'reply' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $comment = Comment::findOrFail($id);
            Replay::create([
                'comment_id' => $comment->id,
                'replay' => $request->reply,
                'added_by' => Auth::user()->id
            ]);
            return response()->json([
                'message' => ' reply added',
                'status' => true
            ], Response::HTTP_OK);


        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }


    }

    public function filtercomments(Request $request)
    {
        $new = strtotime($request->end_due_date);
        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
        $erledigt = (request()->has('erledigt')) ? $request->erledigt : 0;
        $seen = (request()->has('seen')) ? $request->seen : 0;
        $comment = (request()->has('comment')) ? $request->comment : 1;
        $replay = (request()->has('replay')) ? $request->replay : 1;
        if ($start_due_date == '1970-01-01') {
            $start_due_date = null;
        }
        if ($end_due_date == '1970-01-01') {
            $end_due_date = null;
        } else {
            $end_due_date = date('Y-m-d', strtotime("+1 day" . $request->end_due_date));
        }

        /* Defulat Api to display both  Replys  and  comments  */
        if ($comment == 0 && $replay == 0 && empty($start_due_date) && empty($end_due_date) && $seen == 0 && $erledigt == 0) {
            /* View All Comments  */
            $comments = Comment::with('user')->where('account_id', auth()->user()->account_id)->where('status', '!=', 1)->get();
            $notes = new \Illuminate\Database\Eloquent\Collection();
            foreach ($comments as $comment) {
                $read_users = json_decode($comment['readby']);
                if (!empty($comment->tags) && in_array(Auth()->user()->id, explode(',', $comment->tags))) {
                    if (!empty($read_users)) {
                        if (!in_array(Auth()->user()->id, $read_users)) {
                            $notes->push($comment);
                        }
                    } else {
                        $notes->push($comment);
                    }
                }
            }

            /* View All Replays  */

            $replays = Replay::with('user')->get();
            $replays_arr = new \Illuminate\Database\Eloquent\Collection();

            foreach ($replays as $replay) {
                $read_users = json_decode($replay['is_read']);

                if (!empty($replay->tags) && in_array(Auth()->user()->id, explode(',', $replay->tags))) {
                    if (!empty($read_users)) {
                        if (!in_array(Auth()->user()->id, $read_users)) {
                            $replays_arr->push($replay);
                        }
                    } else {
                        $replays_arr->push($replay);
                    }
                }

            }

            $allResults = $replays_arr->merge($notes);
            $allResults = $allResults->SortByDesc('created_at');
            $newnotes = array();
            foreach ($allResults as $new) {
                $newnotes[] = $new;
            }
            return response()->json([
                'messages' => 'all comments with reply',
                'notes' => $newnotes,
                'status' => true
            ], Response::HTTP_OK);

        }
        if ($comment == 0 && $replay == 0 && !empty($start_due_date) && !empty($end_due_date) && $seen == 0 && $erledigt == 0) {
            $comments = Comment::with('user')->where('account_id', auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('status', '!=', 1)->get();
            $notes = new \Illuminate\Database\Eloquent\Collection();
            foreach ($comments as $comment) {
                $read_users = json_decode($comment['readby']);
                if (!empty($comment->tags) && in_array(Auth()->user()->id, explode(',', $comment->tags))) {
                    if (!empty($read_users)) {
                        if (!in_array(Auth()->user()->id, $read_users)) {
                            $notes->push($comment);
                        }
                    } else {
                        $notes->push($comment);
                    }
                }
            }

            /* View All Replays  */

            $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $replays_arr = new \Illuminate\Database\Eloquent\Collection();

            foreach ($replays as $replay) {
                $read_users = json_decode($replay['is_read']);

                if (!empty($replay->tags) && in_array(Auth()->user()->id, explode(',', $replay->tags))) {
                    if (!empty($read_users)) {
                        if (!in_array(Auth()->user()->id, $read_users)) {
                            $replays_arr->push($replay);
                        }
                    } else {
                        $replays_arr->push($replay);
                    }
                }

            }

            $allResults = $replays_arr->merge($notes);
            $allResults = $allResults->SortByDesc('created_at');
            $newnotes = array();
            foreach ($allResults as $new) {
                $newnotes[] = $new;
            }
            return response()->json([
                'messages' => 'all comments with reply',
                'notes' => $newnotes,
                'status' => true
            ], Response::HTTP_OK);


        }
        //comments
        if ($comment == 1 && $replay == 0) {
            if (empty($start_due_date) && empty($end_due_date) && $seen == 0 && $erledigt == 0) {

                $comments = Comment::with('user')->where('account_id', auth()->user()->account_id)->where('status', '!=', 1)->get();
                $notes = [];
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags) && in_array(Auth()->user()->id, explode(',', $comment->tags))) {
                        if (!empty($read_users)) {
                            if (!in_array(Auth()->user()->id, $read_users)) {
                                $notes[] = $comment;
                            }
                        } else {
                            $notes[] = $comment;
                        }
                    }
                }

                return response()->json([
                    'messages' => 'comments only ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 0 && $erledigt == 0) {
                $comments = Comment::with('user')->where('account_id', auth()->user()->account_id)->where('status', '!=', 1)->whereBetween('created_at', [$start_due_date, $end_due_date])->orderBy('created_at', 'desc')->get();
                $notes = [];
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags) && in_array(Auth()->user()->id, explode(',', $comment->tags))) {
                        if (!empty($read_users)) {
                            if (!in_array(Auth()->user()->id, $read_users)) {
                                $notes[] = $comment;
                            }
                        } else {
                            $notes[] = $comment;
                        }
                    }
                }
                return response()->json([
                    'messages' => 'comments with Two dates ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
            if (empty($start_due_date) && empty($end_due_date) && $seen == 0 && $erledigt == 1) {
                $comments = Comment::with('user')->where('status', '!=', 1)->where('done', 1)->orderBy('created_at', 'desc')->get();
                $notes = [];
                foreach ($comments as $comment) {
                    if (!empty($comment->tags)) {
                        $tags = explode(',', $comment->tags);
                        if (in_array(Auth()->user()->id, $tags)) {
                            $notes[] = $comment;
                        }
                    }
                }
                return response()->json([
                    'messages' => 'comments done only ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 0 && $erledigt == 1) {
                $comments = Comment::with('user')->where('status', '!=', 1)->whereBetween('created_at', [$start_due_date, $end_due_date])->where('done', 1)->orderBy('created_at', 'desc')->get();
                $notes = [];
                foreach ($comments as $comment) {
                    if (!empty($comment->tags)) {
                        $tags = explode(',', $comment->tags);
                        if (in_array(Auth()->user()->id, $tags)) {
                            $notes[] = $comment;
                        }
                    }
                }
                return response()->json([
                    'messages' => 'comments done only ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
            if (empty($start_due_date) && empty($end_due_date) && $seen == 1 && $erledigt == 0) {
                $comments = Comment::with('user')->where('status', '!=', 1)->orderBy('created_at', 'desc')->get();
                $notes = [];
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags)) {
                        $tags = explode(',', $comment->tags);
                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $comment->readby = json_decode($comment->readby);
                                    $notes[] = $comment;
                                }
                            }
                        }
                    }
                }
                return response()->json([
                    'messages' => 'comments done only ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 1 && $erledigt == 0) {
                $comments = Comment::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->where('status', '!=', 1)->orderBy('created_at', 'desc')->get();
                $notes = [];
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags)) {
                        $tags = explode(',', $comment->tags);
                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $comment->readby = json_decode($comment->readby);
                                    $notes[] = $comment;
                                }
                            }
                        }
                    }
                }
                return response()->json([
                    'messages' => 'comments done with 2 dates ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 1 && $erledigt == 1) {
                $comments = Comment::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->where('done', 1)->where('status', '!=', 1)->orderBy('created_at', 'desc')->get();
                $notes = [];
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags)) {
                        $tags = explode(',', $comment->tags);
                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $comment->readby = json_decode($comment->readby);
                                    $notes[] = $comment;
                                }
                            }
                        }
                    }
                }
                return response()->json([
                    'messages' => 'comments done  and  erldegate  with 2 dates ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
        }
        //Replays
        if ($comment == 0 && $replay == 1) {
            if (empty($start_due_date) && empty($end_due_date) && $seen == 0 && $erledigt == 0) {
                $replays = Replay::with('user')->get();
                $notes = [];
                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);

                    if (!empty($replay->tags) && in_array(Auth()->user()->id, explode(',', $replay->tags))) {
                        if (!empty($read_users)) {
                            if (!in_array(Auth()->user()->id, $read_users)) {
                                $notes[] = $replay;
                            }
                        } else {
                            $notes[] = $replay;
                        }
                    }

                }
                return response()->json([
                    'messages' => 'All  Replays only ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);

            }
            if (empty($start_due_date) && empty($end_due_date) && $seen == 1 && $erledigt == 0) {
                $replays = Replay::with('user')->get();
                $notes = [];
                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);
                    if (!empty($replay->tags)) {

                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $notes[] = $replay;
                                }
                            }
                        }
                    }
                }
                return response()->json([
                    'messages' => 'All  Replays with done ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);
            }
            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 1 && $erledigt == 0) {
                $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $notes = [];
                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);
                    if (!empty($replay->tags)) {

                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $notes[] = $replay;
                                }
                            }
                        }
                    }
                }

                return response()->json([
                    'messages' => 'All  Replays with  two dates  and   done ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);

            }
            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 0 && $erledigt == 0) {
                $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $notes = [];
                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);
                    if (!empty($replay->tags)) {

                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (!in_array(Auth()->user()->id, $read_users)) {
                                    $notes[] = $replay;
                                }
                            }
                        }
                    }
                }

                return response()->json([
                    'messages' => 'All  Replays with  two dates  and   done ',
                    'notes' => $notes,
                    'status' => true
                ], Response::HTTP_OK);

            }

        }
        //comments  with replays
        if ($comment == 1 && $replay == 1) {
            if (empty($start_due_date) && empty($end_due_date) && $seen == 0 && $erledigt == 0) {
                /* View All Comments  */
                $comments = Comment::with('user')->where('account_id', auth()->user()->account_id)->where('status', '!=', 1)->get();
                $notes = new \Illuminate\Database\Eloquent\Collection();
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags) && in_array(Auth()->user()->id, explode(',', $comment->tags))) {
                        if (!empty($read_users)) {
                            if (!in_array(Auth()->user()->id, $read_users)) {
                                $notes->push($comment);
                            }
                        } else {
                            $notes->push($comment);
                        }
                    }
                }

                /* View All Replays  */

                $replays = Replay::with('user')->get();
                $replays_arr = new \Illuminate\Database\Eloquent\Collection();

                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);

                    if (!empty($replay->tags) && in_array(Auth()->user()->id, explode(',', $replay->tags))) {
                        if (!empty($read_users)) {
                            if (!in_array(Auth()->user()->id, $read_users)) {
                                $replays_arr->push($replay);
                            }
                        } else {
                            $replays_arr->push($replay);
                        }
                    }

                }
            }
            if (!empty($start_due_date) && !empty($end_due_date) && $erledigt == 0 && $seen == 1) {
                $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $replays_arr = new \Illuminate\Database\Eloquent\Collection();
                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);
                    if (!empty($replay->tags)) {

                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $replays_arr->push($replay);
                                }
                            }
                        }
                    }
                }


                $comments = Comment::with('user', 'task')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $notes = new \Illuminate\Database\Eloquent\Collection();
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags)) {

                        $tags = explode(',', $comment->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $notes->push($comment);
                                }
                            }
                        }
                    }
                }

            }
            if (empty($start_due_date) && empty($end_due_date) && $erledigt == 0 && $seen == 1) {
                $replays = Replay::with('user')->get();
                $replays_arr = new \Illuminate\Database\Eloquent\Collection();
                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);
                    if (!empty($replay->tags)) {

                        $tags = explode(',', $replay->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $replays_arr->push($replay);
                                }
                            }
                        }
                    }
                }


                $comments = Comment::with('user', 'task')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $notes = new \Illuminate\Database\Eloquent\Collection();
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags)) {

                        $tags = explode(',', $comment->tags);

                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (in_array(Auth()->user()->id, $read_users)) {
                                    $notes->push($comment);
                                }
                            }
                        }
                    }
                }

            }
            if (!empty($start_due_date) && !empty($end_due_date) && $seen == 0 && $erledigt == 0) {
                $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $replays_arr = new \Illuminate\Database\Eloquent\Collection();
                foreach ($replays as $replay) {
                    $read_users = json_decode($replay['is_read']);
                    if (!empty($replay->tags)) {
                        $tags = explode(',', $replay->tags);
                        if (in_array(Auth()->user()->id, $tags)) {
                            if (!empty($read_users)) {
                                if (!in_array(Auth()->user()->id, $read_users)) {
                                    $replays_arr->push($replay);
                                }
                            } else {
                                $replays_arr->push($replay);
                            }
                        }
                    }
                }


                $comments = Comment::with('user', 'task')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
                $notes = new \Illuminate\Database\Eloquent\Collection();
                foreach ($comments as $comment) {
                    $read_users = json_decode($comment['readby']);
                    if (!empty($comment->tags) && in_array(Auth()->user()->id, explode(',', $comment->tags))) {
                        if (!empty($read_users)) {
                            if (!in_array(Auth()->user()->id, $read_users)) {
                                $notes->push($comment);
                            }
                        } else {
                            $notes->push($comment);
                        }
                    }
                }
            }

            $allResults = $replays_arr->merge($notes);
            $allResults = $allResults->SortByDesc('created_at');
            $newnotes = array();
            foreach ($allResults as $new) {
                if (empty($new->is_read) && $new->is_read !== 0 && $new->is_read !== "0") {
                    $new->is_read = "[]";
                }
                $newnotes[] = $new;
            }
            return response()->json([
                'messages' => 'all comments with reply ',
                'notes' => $newnotes,
                'status' => true
            ], Response::HTTP_OK);
        }
    }


    public function filterReplays(Request $request)
    {

        $new = strtotime($request->end_due_date);
        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
        $seen = (request()->has('seen')) ? $request->seen : 0;
        if ($start_due_date == '1970-01-01') {
            $start_due_date = null;
        }
        if ($end_due_date == '1970-01-01') {
            $end_due_date = null;
        } else {
            $end_due_date = date('Y-m-d', strtotime("+1 day" . $request->end_due_date));
        }
        ////////////////
        if (empty($start_due_date) && empty($end_due_date) && $seen == 0) {


            $replays = Replay::get();
            $replays_arr = [];
            foreach ($replays as $replay) {
                $read_users = json_decode($replay['is_read']);
                if (!empty($replay->tags)) {
                    $tags = explode(',', $replay->tags);
                    if (in_array(Auth()->user()->id, $tags)) {
                        $replays_arr[] = $replay;
                    }
                }
            }

        }
        //////////////////////////////
        if (!empty($start_due_date) && !empty($end_due_date) && $seen == 0) {
            $replays = Replay::whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $replays_arr = [];
            foreach ($replays as $replay) {
                if (!empty($replay->tags)) {
                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        $replays_arr[] = $replay;
                    }
                }
            }

        }

        if (!empty($start_due_date) && !empty($end_due_date) && $seen == 1) {
            $replays = Replay::whereBetween('created_at', [$start_due_date, $end_due_date])->get();

            $replays_arr = [];
            foreach ($replays as $replay) {
                $read_users = json_decode($replay['is_read']);
                if (!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if (!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $replays_arr[] = $replay;
                            }
                        }
                    }
                }
            }

        }


        if (empty($start_due_date) && empty($end_due_date) && $seen == 1) {
            $replays = Replay::get();
            $replays_arr = [];
            foreach ($replays as $replay) {
                $read_users = json_decode($replay['is_read']);
                if (!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if (!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $replays_arr[] = $replay;
                            }
                        }
                    }
                }
            }

        }

        return response()->json([
            'replays' => $replays_arr,
            'status' => true
        ], Response::HTTP_OK);

    }

    // End Filter Replays

    public function filltercommentsandreplays(Request $request)
    {
        $new = strtotime($request->end_due_date);
        $start_due_date = date('Y-m-d', strtotime($request->start_due_date));
        $end_due_date = date('Y-m-d', strtotime($request->end_due_date));
        $erledigt = (request()->has('erledigt')) ? $request->erledigt : 0;
        $seen = (request()->has('seen')) ? $request->seen : 0;
        if ($start_due_date == '1970-01-01') {
            $start_due_date = null;
        }
        if ($end_due_date == '1970-01-01') {
            $end_due_date = null;
        } else {
            $end_due_date = date('Y-m-d', strtotime("+1 day" . $request->end_due_date));
        }

        if (empty($start_due_date) && empty($end_due_date) && $seen == 0 && $erledigt == 0) {

            $comments = Comment::with('user', 'task')->get();
            $notes = [];
            foreach ($comments as $comment) {

                if (!empty($comment->tags)) {

                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        $notes[] = $comment;
                    }
                }
            }

            $replays = Replay::with('user')->get();
            $replays_arr = [];
            foreach ($replays as $replay) {

                if (!empty($replay->tags)) {

                    $tags2 = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags2)) {
                        $replays_arr[] = $replay;
                    }
                }
            }

        }


        if (!empty($start_due_date) && !empty($end_due_date) && $seen == 0 && $erledigt == 0) {
            $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $replays_arr = [];
            foreach ($replays as $replay) {
                if (!empty($replay->tags)) {
                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        $replays_arr[] = $replay;
                    }
                }
            }

            $comments = Comment::with('user', 'task')->where('account_id', auth()->user()->account_id)->whereBetween('created_at', [$start_due_date, $end_due_date])->get();
            $notes = [];
            foreach ($comments as $comment) {
                if (!empty($comment->tags)) {
                    $tags2 = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags2)) {
                        $notes[] = $comment;
                    }
                }
            }

        }

        if (!empty($start_due_date) && !empty($end_due_date) && $seen == 1 && $erledigt == 0) {


            $replays = Replay::with('user')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();

            $replays_arr = [];
            foreach ($replays as $replay) {
                $read_users = json_decode($replay['is_read']);
                if (!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if (!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $replays_arr[] = $replay;
                            }
                        }
                    }
                }
            }

            $comments = Comment::with('user', 'task')->whereBetween('created_at', [$start_due_date, $end_due_date])->get();

            $notes = [];
            foreach ($comments as $comment) {
                $read_users = json_decode($comment['readby']);
                if (!empty($comment->tags)) {

                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if (!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $notes[] = $comment;
                            }
                        }
                    }
                }
            }

        }


        if (empty($start_due_date) && empty($end_due_date) && $seen == 1) {
            $replays = Replay::with('user')->get();
            $replays_arr = [];
            foreach ($replays as $replay) {
                $read_users = json_decode($replay['is_read']);
                if (!empty($replay->tags)) {

                    $tags = explode(',', $replay->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if (!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $replays_arr[] = $replay;
                            }
                        }
                    }
                }
            }


            $comments = Comment::with('user', 'task')->get();
            $notes = [];
            foreach ($comments as $comment) {
                $read_users = json_decode($comment['readby']);
                if (!empty($comment->tags)) {

                    $tags = explode(',', $comment->tags);

                    if (in_array(Auth()->user()->id, $tags)) {
                        if (!empty($read_users)) {
                            if (in_array(Auth()->user()->id, $read_users)) {
                                $notes[] = $comment;
                            }
                        }
                    }
                }
            }

        }

        return response()->json([
            'comments' => $notes,
            'replays' => $replays_arr,
            'status' => true
        ], Response::HTTP_OK);

    }

    //done comment

    public function donecomment(Request $request)
    {

        try {
            $data = $request->all();
            $donecomment = Comment::where(['id' => $data['comment_id']])->first();
            $donecomment->done = $data['value'];
            $donecomment->save();

            /* Add The  Reason  to Replay */
            $replay = new Replay();
            $replay->comment_id = $data['comment_id'];
            $replay->replay = $data['reason'];
            $replay->added_by = auth::user()->first_name ;
            $replay->added_by_id = auth::user()->id;
            $replay->task_id = $data['task_id'];
            $replay->tags = null;

            $replay->comment_author = $data['comment_author'];
            $replay->save();

            return response()->json([
                'message' => 'Comment is done  Successfuly ',
                'status' => true
            ], Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
