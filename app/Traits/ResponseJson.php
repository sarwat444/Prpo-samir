<?php
namespace App\Traits;

trait ResponseJson
{
    public function responseJson($data, $code = 200,$headers = []): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $code)->withHeaders($headers);
    }

    public function sendResponse($result)
    {
    	$response = [

            'data'    => $result
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 200)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
