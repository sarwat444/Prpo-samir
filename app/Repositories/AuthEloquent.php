<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\ResponseJson;
use Validator;

class AuthEloquent {

    use ResponseJson;
    public function login($request) {

        try {
            if(Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password , 'deleted' => 0 ])){
                $user                 = Auth::user();
                $user->fcm_token      = $request->fcm_token;
                $user->save();
                $user['token']          = $user->createToken('MyApp')->accessToken;
                $user['user_id']        = $user->id;
                $user['user_firstname'] = $user->first_name;
                $user['user_lastname']  = $user->last_name;
                $user['user_avatar']    = $user->image;
                return $this->sendResponse($user , 'user login successfully.');
            }
            else {
                $success   = false;
                return $this->sendError('Unauthorised' , $success);
            }
        } catch (\Exception $e) {
           //dd($e);
                $message = 'error';
                $status  = false;
                return $this->sendError( $message , $status);
        }

    }


    public function register($request) {
        DB::beginTransaction();
        try {
                $validator   =  $this->validate_data($request);
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors()->first());
                }
                $input                   = [];
                $input['password']       = bcrypt($request->user_password);
                $input['user_firstname'] = $request->user_firstname;
                $input['lastname']       = $request->user_lastname;
                $input['name']           = $request->user_name;
                $input[ 'email']         = $request->user_email;
                $input[ 'password']      = $request->user_password;
                $user                    =  User::create($input);
                $success      = null;
                DB::commit();
                return $this->sendResponse('data addeded successfully.');

        }catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return $this->sendError('Server Error.', 'something wrong happen');
        }
    }

    public function validate_data($request) {

        $validator = Validator::make($request->all(), [
              'user_firstname'      => 'required',
              'user_lastname'       => 'required',
              'user_name'           => 'required',
              'user_email'          => 'required',
              'user_password'       => 'required',
            //  'user_mobile'         => 'required',
          ]);

      return $validator;
    }

    public function delete() {

        $user    = auth()->guard('api')->user();
        if($user) {
           $user->deleted = 1;
           $user->save();
           $success    = true;
           return $this->sendResponse($success , 'user deleted successfully');

        }
    }

    public function toggleRegister() {
        return $this->sendResponse(0 , 'done successfully.');
    }


}
