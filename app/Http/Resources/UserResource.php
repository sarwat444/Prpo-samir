<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use getID3;
use getid3_lib;
use App\Models\GroupSeen;


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if($this->chat_room_type == 'Private') {
             if ($this->guest_user_id != auth()->guard('api')->user()->id) {
                $room_name = $this->guest_firstname .' '.$this->guest_lastname;
                $to        = $this->guest_user_id;

             }else {
                $room_name = $this->admin_firstname .' ' . $this->admin_lastname;
                $to        = $this->admin_user_id;
             }
        } else {
            $room_name = $this->chat_room_name;
            $to        = 0;
        }

        return [
            'chat_room_id'       => $this->chat_room_id,
            'chat_room_creator'  => $this->chat_room_creator,
            'user_name'          => $room_name ,
            'guest_mobile'       => $this->guest_mobile ,
            'creator_mobile'     => $this->admin_mobile  ,
            'chat_room_type'     => $this->chat_room_type,
            'to'                 => $to,
            'avatar'             => ($this->chat_room_type == 'Private') ? 'https://halalcheck-crm.de/assets/images/users/avatar/'. $this->guest_user_id . '/' . $this->guest_avatar : $this->chat_room_image,
            'time'               => (!empty($this->last_msg)) ? date('H:i A' , strtotime($this->last_msg)) : null ,
            'last_msg'           => (!empty($this->msg)) ? my_cryption($this->msg, 'd') : null,
            'last_msg_from'      => $this->chat_from,
            'chat_timestamp'     => $this->last_msg,
            'chat_message_type'  => $this->chat_message_type,
            'is_seen'            => $this->is_seen,
            'unseen_count'       => ($this->chat_room_type == 'Private') ? $this->count  :  GroupSeen::where(['user_id' => auth()->guard('api')->user()->id , 'group_id' => $this->chat_room_id ])->first()->un_read ?? 0,
            'duration'           =>  $this->voice_duration
        ];

       // return parent::toArray($request);
    }
}
