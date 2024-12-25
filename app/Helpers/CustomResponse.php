<?php
namespace App\Helpers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomResponse
{
    public function internalError(\Exception $exception): JsonResponse
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'message'=>$exception->getMessage(),
                'status' =>false
            ],Response::HTTP_NOT_FOUND);
        }


            return response()->json([
            'message'=>$exception->getMessage(),
            'status' =>false
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
