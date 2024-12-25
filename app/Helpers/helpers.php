<?php

use App\Models\GroupSeen;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Services\S3Service;

use Google\Auth\OAuth2;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Cloud\Core\ExponentialBackoff;
use GuzzleHttp\Client;


if (! function_exists('my_cryption')) {

    function my_cryption ( $string, $action = 'e', $code = 'standart') {

        switch ( $code ) {
            case "standart":
                $secret_key = 'thisIsmySecretKey:)';
                $secret_iv = 'thisIsmySecretIv:)';
                break;
            case 'hc_login':
                $secret_key = 'cre@t€L0g!nK€y123)';
                $secret_iv = 'cre@t€L0g!n!V123)';
                break;
            case 'sp_login':
                $secret_key = 'Cr€d@nti@l:1ogin:key)';
                $secret_iv  = 'Cr€d@nti@l:1ogin:Iv)';
                break;
            case "hco_url":
                $secret_key = '!URL:ch@nge:123)key';
                $secret_iv = '!URL:ch@nge:123)iv';
                break;
            case "chat":
                $secret_key = '!URL:ch@t:123)key';
                $secret_iv = '!URL:ch@t:123)iv';
                break;
            case "transaction":
                $secret_key = '!m0n€y:ch@nge:123)key';
                $secret_iv = '!m0n€y:ch@nge:123)iv';
                break;
            case "video":
                $secret_key = '!V!d€0:123)key';
                $secret_iv = '!V!d€0:123)iv';
                break;
            case 'article':
                $secret_key = 'cre@t€/@rt!cl€/K€y123)';
                $secret_iv = 'cre@t€/@rt!cl€/!V123)';
            case "course":
                $secret_key = '!C0ur$€:123)key';
                $secret_iv = '!C0ur$€:123)iv';
                break;
            case "url":
                $secret_key = '!URL:ch@nge:123)key';
                $secret_iv = '!URL:ch@nge:123)iv';
                break;
            default:
                $secret_key = 'thisIsmySecretKey:)';
                $secret_iv = 'thisIsmySecretIv:)';
        }

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }

        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;
    }

}

if (! function_exists('insert_data')) {
    function insert_data($table, $data) {
        $id = DB::table($table)->insertGetId($data);
        return $id;
    }
}

if (! function_exists('uploadImage')) {
    function uploadImage($image) {
       /* $path = public_path('uploads/message/images');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }*/
        $file      = $image;
        $fileName  = uniqid() . '_' . trim($file->getClientOriginalName());
        $fileName  = str_replace(' ', '', $fileName);
        // $file->move($path, $fileName);
        $file->storeAs('message/images/' ,   $fileName ,  's3');
        return   $fileName ;
    }
}

if (! function_exists('uploadVideo')) {
    function uploadVideo($video) {
        $file     = $video;
        $fileName = uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $fileName  = str_replace(' ', '', $fileName);
        $file->storeAs('message/videos/' ,   $fileName ,  's3');
        return  $fileName;
    }
}

if (! function_exists('uploadVoice')) {
    function uploadVoice($voice) {
       /* $path = public_path('uploads/message/voices');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }*/
        $file      = $voice;
        $fileName  = uniqid() . '_' . trim($file->getClientOriginalName());
        $fileName  = str_replace(' ', '',$fileName);
        $fileName  = str_replace('.aac', '.mp3', $fileName);
        $fileName  = str_replace(' ', '', $fileName);
    //    $file->move($path, str_replace(' ', '',$fileName));
         $file->storeAs('message/voices/' ,   $fileName ,  's3');
        return $fileName;
    }
}

if (! function_exists('uploadDoc')) {
    function uploadDoc($doc) {
      /*  $path = public_path('uploads/message/docs');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }*/

        $file      = $doc;
        $fileName  = uniqid() . '_' . trim($file->getClientOriginalName());
        $fileName  = str_replace(' ', '',$fileName);
       // $file->move($path, str_replace(' ', '',$fileName));
        $file->storeAs('message/docs/' ,   $fileName ,  's3');
        return $fileName;
    }
}

if (! function_exists('send_notification')) {
    function send_notification($user , $pusher_data) {

        try {
            $user        = User::where('id' , $user)->select('fcm_token')->first();
            $deviceToken = @$user->fcm_token;
            $apiKeyPath  = __DIR__ . '/firebase_credentials.json';
            $projectId   = 'chat-app-9e790';
            $key         = json_decode(file_get_contents($apiKeyPath), true);
            $scopes      = ['https://www.googleapis.com/auth/firebase.messaging'];
            $credentials = new ServiceAccountCredentials($scopes, $key);
            // Get the access token
            $accessToken = $credentials->fetchAuthToken()['access_token'];
            // Create the message payload
       //  dd($pusher_data['chat_to']);

            $message = [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title'              =>  auth()->guard('api')->user()->first_name .  ' ' . auth()->guard('api')->user()->last_name,
                        'body'               =>  $pusher_data['chat_message']
                    ],'data'  =>   [
                        "click_action"        =>  "FLUTTER_NOTIFICATION_CLICK",
                        'chat_id'             =>  (string)$pusher_data['chat_id'],
                        'chat_room_id'        =>  (string)$pusher_data['chat_room_id'],
                        'chat_from'           =>  (string)$pusher_data['chat_from'],
                        'chat_to'             =>  ( $pusher_data['chat_type'] != 'Gruppe') ? implode(',', $pusher_data['chat_to']) : (string)$pusher_data['chat_to'],
                        'chat_message'        =>  (string)$pusher_data['chat_message'],
                        'time'                =>  (string)$pusher_data['time'],
                        'chat_message_type'   =>  $pusher_data['chat_message_type'],
                        'chat_attachment'     =>  $pusher_data['chat_attachment'],
                        'unseen_count'        =>  (string)$pusher_data['unseen_count'],
                        'chat_type'           =>  $pusher_data['chat_type'],
                        'chat_seen'           =>  isset($pusher_data['chat_seen']) ? (string)$pusher_data['chat_seen']:'0',
                        'chat_favorite'       =>  '0',
                        "user_id"             => (string)auth()->guard('api')->user()->id,
                        "user_firstname"      => auth()->guard('api')->user()->first_name,
                        "user_lastname"       => auth()->guard('api')->user()->last_name,
                        "user_avatar"         => auth()->guard('api')->user()->image,
                        'room_name'           =>  ( $pusher_data['chat_type'] == 'Gruppe') ? (string)@$pusher_data['room_name'] : null,
                        'chat_timestamp'      => @$pusher_data['chat_timestamp'],
                    ],
                ]
            ];
            // Set up the request headers
            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ];

            // Send the request
            $client = new Client();
            $response = $client->post(
                "https://fcm.googleapis.com/v1/projects/$projectId/messages:send",
                [
                    'headers' => $headers,
                    'json'    => $message
                ]
            );

        }catch(Exception $e) {
            //  $errorResponse = $e->getResponse();
//dd($e);
        }

    }
}

if (! function_exists('seen_messages')) {
    function seen_messages($user , $room_id) {
        $gorup_seen = GroupSeen::where(['user_id' => $user , 'group_id' => $room_id ])->first();
        if ($gorup_seen) {
            $gorup_seen->un_read = $gorup_seen->un_read + 1;
            $gorup_seen->save();
        }else {
            $gorup_seen = new GroupSeen();
            $gorup_seen->user_id  = $user;
            $gorup_seen->group_id = $room_id;
            $gorup_seen->un_read  = 1;
            $gorup_seen->save();
        }
    }
}

if (! function_exists('send_delete_notification')) {
    function send_delete_notification($user , $pusher_data) {

        try {
            $user        = User::where('id' , $user)->select('fcm_token')->first();
            $deviceToken = @$user->fcm_token;
            $apiKeyPath  = __DIR__ . '/firebase_credentials.json';
            $projectId   = 'chat-app-9e790';
            $key         = json_decode(file_get_contents($apiKeyPath), true);
            $scopes      = ['https://www.googleapis.com/auth/firebase.messaging'];
            $credentials = new ServiceAccountCredentials($scopes, $key);
            // Get the access token
            $accessToken = $credentials->fetchAuthToken()['access_token'];
            // Create the message payload
       //  dd($pusher_data['chat_to']);

            $message = [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title'              =>  auth()->guard('api')->user()->first_name .  ' ' . auth()->guard('api')->user()->last_name,
                        'body'               =>  'user delete message'
                    ],'data'  =>   [
                        "click_action"        =>  "FLUTTER_NOTIFICATION_CLICK",
                        'chat_id'             =>  (string)$pusher_data['chat_id'],
                        'chat_to'             =>  (string)$pusher_data['chat_to'],
                        'chat_room_id'        =>  (string)$pusher_data['chat_room_id'],
                        "action_type"         => 'delete_msg',
                    ],
                ]
            ];
            // Set up the request headers
            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json'
            ];

            // Send the request
            $client = new Client();
            $response = $client->post(
                "https://fcm.googleapis.com/v1/projects/$projectId/messages:send",
                [
                    'headers' => $headers,
                    'json'    => $message
                ]
            );

        }catch(Exception $e) {
            //  $errorResponse = $e->getResponse();
//dd($e);
        }

    }
}



