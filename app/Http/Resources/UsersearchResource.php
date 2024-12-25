<?php

namespace App\Http\Resources;

use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user_id     = auth()->guard('api')->user()->id;
        $chat_room   = ChatRoom::with('last_msg')
                                ->where('chat_room_creator' , $this->id)->where('chat_room_users', $user_id)->where('chat_room_type' , 'Private')
                                ->orWhere('chat_room_creator' , $user_id)->where('chat_room_users', $this->id)->where('chat_room_type' , 'Private')->first();
        if( $chat_room) {
            if(!empty( $chat_room->last_msg->chat_message)) {
                $chat_room->last_msg->chat_message = my_cryption($chat_room->last_msg->chat_message, 'd');
            }

            $chat_room->time    = (!empty($chat_room->last_msg->chat_timestamp)) ? date('H:i A' , strtotime($chat_room->last_msg->chat_timestamp)) : null ;

            $chat_room['unseen_count']  = Chat::where('chat_room_id', $chat_room->chat_room_id )
                                                ->where('chat_to',   $user_id)
                                                ->where('chat_seen' , 0)
                                                ->count();
        }

        return [
            'user_id'        => $this->id, // Assuming 'id' is the primary key
            'user_firstname' => $this->first_name,
            'user_lastname'  => $this->last_name,
            'user_mobile'    => $this->user_mobile ,
            'user_avatar'    => "https://developer.jboss.org/images/jive-sgroup-default-portrait-large.png", //(!empty($this->user_avatar)) ? 'https://halalcheck-crm.de/assets/images/users/avatar/'. $this->user_avatar  : "https://developer.jboss.org/images/jive-sgroup-default-portrait-large.png",
            'chat_room'      =>  $chat_room
        ];
    }
}
