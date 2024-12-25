<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\changePassword;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }


        if (Auth::attempt(['user_name' => request('username'), 'password' => request('password')])) {
            $user = auth()->user();
            $user['token'] = $user->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['message' => 'Logged In Successfully', 'user' => $user, 'status' => true]);
        } else {
            return response()->json([
                'message' => 'UserName Or Password  Incorrect',
                'status' => true
            ]);
        }
    }

    public function forget_password(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false]);
        }
        try {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz!@#$%^&*';
            $code = substr(str_shuffle($data), 0, 10);
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'message' => 'mail existiert nicht',
                    'status' => false
                ]);
            }
            $user->verification_code = $code;
            $user->save();
            $url = route('get-forget-password');
            Mail::to($request->email)->send(new changePassword($code, $url));
            return response()->json([
                'message' => 'Code an Ihre E-Mail angehängt, überprüfen Sie es',
                'status' => true
            ]);

        } catch (\Exception  $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false
            ]);
        }

    }

    public function get_forget_password()
    {
        return view('reset-password');
    }

    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => false
            ]);
        } else {
            try {
                $user = User::where('email', $request->email)->where('verification_code', $request->code)->first();

                if (!empty($user)) {
                    $user->password = Hash::make(request('password'));
                    $user->verification_code = null;
                    $user->save();
                    return response()->json([
                        'message' => 'password reset',
                        'status' => true
                    ]);
                } else {
                    return response()->json([
                        'message' => 'invalid credentials',
                        'status' => false
                    ]);
                }
            } catch (\Exception $ex) {

                return response()->json([
                    'message' => $ex->getMessage(),
                    'status' => false
                ]);
            }
        }
    }

    public function Change_Password(Request $request)
    {
        try {
            $userid = Auth::guard('api')->user()->id;
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'status' => false
                ], 400);
            }

            if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                return response()->json(["status" => false, "message" => "Your old password Is Wrong."]);
            } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                return response()->json(
                    ["status" => false,
                        "message" => "Please enter a password which is not similar then current password."
                    ]);
            } else {
                User::where('id', $userid)->update(['password' => Hash::make(request('new_password'))]);
                return response()->json(["status" => true, "message" => "Password updated successfully."]);
            }
        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false,

            ]);
        }

    }

    public function ResgisterSettings() {
         $register  = 1 ;
         return response()->json([
            'register'  => $register,
             'status'   => true,
         ] , 200) ;

    }

    public function storeRegister(Request $request) {
        //     dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'user_name' => 'required|unique:users',

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

    public function deleteUser(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        $data->delete();
        $msg = 'Data Deleted Successfully';
        return response()->json([
            "status" => true,
            "msg" => $msg
        ], 200);

    }


}
