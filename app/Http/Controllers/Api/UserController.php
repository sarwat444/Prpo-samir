<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TaskTeam;
use Illuminate\Http\JsonResponse;
use App\Helpers\CustomResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{


    protected $response;

    public function __construct(CustomResponse $response)

    {
        $this->response = $response;
    }

    public function index():JsonResponse
    {
        try {
            $users= User::where('account_id',Auth::user()->account_id)->get();
            return response()->json([
                'users' =>$users,
                'status' =>true
            ],Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }
    public function find($id) :JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'user' => $user,
                'status' =>true
            ],Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }

    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'user_name' => 'required|unique:users',
            'first_name' => 'required|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false
            ], 400);
        }

        $user = new User;
        $path = "";
        if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
            $image = $request->file('image');
            $image_ext = $image->getClientOriginalExtension();
            $path = rand(123456, 999999) . "." . $image_ext;
            $destination_path = public_path('assets/images/users/');
            $image->move($destination_path, $path);
            $input['image'] = $path;
        }
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->user_name  = $request->user_name;
        $user->email      = $request->email;
        $user->password   = bcrypt($request->password);
        $user->image      = $path;
        $user->save();
        $user['token']    = $user->createToken('LaravelAuthApp')->accessToken;
        return response()->json(['message' => 'Data Added Successfully', 'user' => $user, 'status' => true]);

    }

    public function update(Request $request,$id) :JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'string',
            'last_name'  => 'string',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' =>$validator->errors()->first(),
                'status' =>false
            ],Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = User::findOrFail($id);
            if (isset($request->first_name) && $request->first_name !== ''){
                $user->first_name = $request->first_name;
            }

            if (isset($request->last_name) && $request->last_name !== ''  ){
                $user->last_name = $request->last_name;

            }

            if (isset($request->password) && $request->password !== ''){
                $user->password = bcrypt($request->password);
            }

            $user->save();
            return response()->json([
                'user' => $user,
                'status' =>true
            ],Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }

    }

    public function profile():JsonResponse
    {
        try {
            $id =Auth::user()->id;
            $user = User::findOrFail($id);
            return response()->json([
                'user' => $user,
                'status' =>true
            ],Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function destroy($id) :JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->deleted =1;
            $user->save();
            return response()->json([
                'user' => $user,
                'status' =>true
            ],Response::HTTP_OK);

        } catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }

    }

    public function postIt():JsonResponse
    {
        try {
            $user = Auth::user();
            $tasks= TaskTeam::where('user_id',$user->id)->where('account_id',$user->account_id)->with('task')->get();;
            return response()->json([
                'tasks' => $tasks,
                'status' => true
            ],Response::HTTP_OK);

        }catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function userPostIt($id):JsonResponse
    {

        try {
            $user = Auth::user();
            $tasks= TaskTeam::where('user_id',$id)->where('account_id',$user->account_id)->with('task')->get();;
            return response()->json([
                'tasks' => $tasks,
                'status' => true
            ],Response::HTTP_OK);

        }catch (\Exception $exception) {
            return $this->response->internalError($exception);
        }
    }

    public function storeGuest(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'user_name' => 'required|unique:users',
            'first_name' => 'required|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false
            ], 400);
        }

        $user = new User;
        $path = "";
        if ($request->hasFile('image') && !empty($request->hasFile('image'))) {
            $image = $request->file('image');
            $image_ext = $image->getClientOriginalExtension();
            $path = rand(123456, 999999) . "." . $image_ext;
            $destination_path = public_path('assets/images/users/');
            $image->move($destination_path, $path);
            $input['image'] = $path;
        }
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->user_name  = $request->user_name;
        $user->email      = $request->email;
        $user->role = 3;
        $user->password   = bcrypt($request->password);
        $user->image      = $path;
        $user->save();
        //$user['token']    = $user->createToken('LaravelAuthApp')->accessToken;
        return response()->json(['message' => 'Data Added Successfully', 'user' => $user, 'status' => true]);

    }

    public function invite(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false
            ], 400);
        }

        return response()->json(['message' => 'Email sent successfully', 'status' => true]);

    }

}
