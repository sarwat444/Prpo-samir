<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\CustomResponse;
use App\Models\Replay;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    protected $response;

    /**
     * @param $response
     */
    public function __construct(CustomResponse $response)
    {
        $this->response = $response;
    }
    public function find($id):JsonResponse
    {
        try {
            $reply =Replay::findOrFail($id);
            return response()->json([
                'reply' => $reply,
                'status' => true
            ],Response::HTTP_OK);

        }catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }
    public function destroy($id):JsonResponse
    {
        try {
            $reply =Replay::findOrFail($id);
            $reply->delete();
            return response()->json([
                'reply'=>'reply deleted',
                'status' => true
            ],Response::HTTP_OK);

        }catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }

    public function update(Request $request,$id):JsonResponse
    {
        try {
            $validator =Validator::make($request->all(),[
                'reply' =>'required'
            ]);
            if ($validator->fails()){
                return response()->json([
                    'message'=>$validator->errors()->first(),
                    'status' =>false
                ],Response::HTTP_BAD_REQUEST);
            }
            $reply =Replay::findOrFail($id);
            $reply->replay = $request->reply;
            $reply->save();
            return response()->json([
                'reply'=>'reply updated',
                'task'=>$reply,
                'status' => true
            ],Response::HTTP_OK);

        }catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }



}
