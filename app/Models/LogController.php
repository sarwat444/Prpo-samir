<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Helpers\CustomResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogController extends Controller
{

    protected $response;

    /**
     * @param $response
     */
    public function __construct(CustomResponse $response)
    {
        $this->response = $response;
    }

    public function index():JsonResponse
    {
        try {
            $logs = Log::with('userImage')->paginate(config('constants.PER_PAGE'));
            return response()->json([
                'notifications' =>  $logs,
                'status' =>true
            ],Response::HTTP_OK);

        } catch (\Exception $exception) {

            return $this->response->internalError($exception);

        }
    }
}
