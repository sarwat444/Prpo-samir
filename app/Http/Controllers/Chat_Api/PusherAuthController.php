<?php

namespace App\Http\Controllers\Chat_Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;

class PusherAuthController extends Controller
{
    public function authenticate(Request $request)
    {

        $channelName = $request->channel_name;
        $user = auth()->guard('api')->user();  // Assuming you have authentication set up in your Laravel app
        $channelData = [
                'user_id' => $user->id,
                'user_info' => [
                    'name' => $user->user_name,

                ],
            ];
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                ]
            );

            $socketId   = $request->socket_id;
            $auth       = $pusher->socket_auth($channelName, $socketId);


        return response($auth);



    /*  $channelName = $request->channel_name;
      $user        = auth()->guard('api')->user();

      $pusher = new Pusher(
          env('PUSHER_APP_KEY'),
          env('PUSHER_APP_SECRET'),
          env('PUSHER_APP_ID'),
          [
              'cluster' => env('PUSHER_APP_CLUSTER'),
              'useTLS' => true, // Enable this if you're using HTTPS
          ]
      );

      if ($channelName == 'presence-halal_chat_app') {
          $socketId = $request->channel_data;
          $channelData = [
              'user_id' => $user->user_id,
              'user_info' => [
                  'name' => $user->user_name,
                  'email' => $user->user_email,
              ],
          ];

          $auth = $pusher->presence_auth($channelName, $socketId, $user->user_id, $channelData);
          $response                  = json_decode($auth, true);
          $sharedSecret              = "0947d2aa9854bad9dedc";
          $response['channel_data']  = json_decode($response['channel_data'], true);
          $response['shared_secret'] = $sharedSecret;
          // Print the modified response
          return json_encode($response, JSON_PRETTY_PRINT);
      } else {
          $socketId = $request->socket_id;
          $auth = $pusher->socket_auth($channelName, $socketId);
          return response()->json($auth);
      }

    //  return json_encode($auth);
       // return response()->json(json_decode($auth), 200);

      */
    }














}
