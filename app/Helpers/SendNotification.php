<?php

namespace App\Helpers;

class SendNotification
{

    public function send_notification_FCM( $fcm_token, $title, $message )
    {
        $accesstoken = env('FCM_SERVER_KEY');
        $URL = 'https://fcm.googleapis.com/fcm/send';

        $data = [
            "registration_ids" => array($fcm_token),

            "notification" => [
                "title" => $title,
                "body" => $message,
                "sound" => "default",
                "content_available" => true,
                "priority" => "high",
            ],
        ];


        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $accesstoken,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
    }
}
