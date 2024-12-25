<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Comment;
use App\Models\User;
use App\Models\Replay;
use App\Helpers\CustomResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            $user = Auth::user();
            $comments = Comment::where('comment_added_by', $user->id)->with('user:id,user_name,image')->paginate(config('constants.PER_PAGE'));
            return response()->json([
                'subtasks' => $comments,
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

    public function taggedComments(): JsonResponse
    {
        try {

            $comments = Comment::with('added_by','task')->get();
            $tagged_comments = [];
            foreach ($comments as $comment) {
                if (!empty($comment->tags)) {
                    $tags = explode(',', $comment->tags);
                    if (in_array(Auth()->user()->id, $tags)) {
                            $read_by_ids = json_decode($comment->readby);                        
                            if(!empty( $read_by_ids)) {
                            if(!in_array(Auth()->user()->id , $read_by_ids)) {
                                $comment->status     = 0;
                            }else {
                                $comment->status     = 1;
                            } 
                            }else {
                                $comment->status     = 0;
                            }
                            // $comment->readby   = $readby_users;
                            $tagged_comments[] = $comment;    
                    }

                      
                }
            }
            return response()->json([
                'comments' => $tagged_comments,
                'status' => true
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }

    }

    public function seenComment($id): JsonResponse
    {
        try {


            $comment = Comment::findOrFail($id);

            $tags = explode(',', $comment->tags);
            if (empty($comment->tags)) {
                return response()->json([
                    'message' => ' list tags are empty',
                    'status' => false
                ], Response::HTTP_UNAUTHORIZED);

            }
            if (!in_array(Auth()->user()->id, $tags)) {
                return response()->json([
                    'message' => ' you are not in tags list',
                    'status' => false
                ], Response::HTTP_UNAUTHORIZED);

            }

            if ($comment->status === 0) {
                $comment->status = 1;
                $comment->save();
                return response()->json([
                    'message' => 'updated to seen',
                    'status' => true
                ], Response::HTTP_OK);
            }
            $comment->status = 0;
            $comment->save();
            return response()->json([
                'message' => 'updated to unseen',
                'status' => true
            ], Response::HTTP_OK);

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
              'reply'=>'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], Response::HTTP_BAD_REQUEST);
            }
            $comment = Comment::findOrFail($id);
            Replay::create([
                'comment_id'=>$comment->id,
                'replay' =>$request->reply,
                'added_by' =>Auth::user()->id
            ]);
            return response()->json([
                'message' => ' reply added',
                'status' =>true
            ],Response::HTTP_OK);



        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }


    }

}
