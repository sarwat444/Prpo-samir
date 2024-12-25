<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  public function addUser( $user_id , $first_name , $last_name , $user_name , $user_email , $password )  {
                 $user = new User;
                 $user->id         = $user_id;
                 $user->first_name = $first_name;
                 $user->last_name  = $last_name;
                 $user->user_name  = $user_name;
                 $user->email      = $user_email;
                 $user->password =  bcrypt($password);
                 $user->account_id = 0;
                 $user->save();



                 return response()->json(['msg' => "User Added Successfully" ,'status' => true ]);


     }

     public function editUserPass( $user_id ,$password )  {
          $user_id = $this->my_cryption($user_id ,'d', 'inspire_login');
          $password = $this->my_cryption($password ,'d', 'inspire_login');
        //  dd($user_id  . '  pass : '   . $password);
          $user =  User::find($user_id);
         if(!empty($user)) {
          $user->password =  bcrypt($password);
          $user->save();
            return response()->json(['msg' => "User Password  Updated Successfully" ,'status' => true ]);
         }else {
              return response()->json(['msg' => "User Not Found" ,'status' => false ]);
         }


   }

   public function my_cryption ($string, $action = 'e', $code = 'login') {
         $secret_key = 'thisIsmySecretKey:)';
         $secret_iv = 'thisIsmySecretIv:)';
         $output = false;
         $encrypt_method = "AES-256-CBC";
         $key = hash( 'sha256', $secret_key );
         $iv  = substr( hash( 'sha256', $secret_iv ), 0, 16 );

         if( $action == 'e' ) {
             $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
         }

         else if( $action == 'd' ){
             $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
         }

         return $output;
   }


 }
