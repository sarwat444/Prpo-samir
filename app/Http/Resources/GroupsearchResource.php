<?php

namespace App\Http\Resources;

use App\Models\GroupSeen;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupsearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $unseen_count = GroupSeen::where(['user_id' => auth()->guard('api')->user()->id , 'group_id' => $this->chat_room_id ])->first()->un_read ?? 0;
        if(!empty( $this->last_msg->chat_message)) {
            $this->last_msg->chat_message = my_cryption($this->last_msg->chat_message, 'd');
        }
        return [
            'chat_room_id'           => $this->chat_room_id,
            'chat_room_creator'      => $this->chat_room_creator,
            'chat_room_users'        => $this->chat_room_users,
            'chat_room_type'         => $this->chat_room_type,
            'chat_room_name'         => $this->chat_room_name,
            'chat_room_image'        => $this->chat_room_image,
            'chat_room_creator_open' => $this->chat_room_creator_open,
            'chat_room_user_open' => $this->chat_room_user_open,
            'chat_room_timestamp' => $this->chat_room_timestamp,
            'creator_updated_at'  => $this->creator_updated_at,
            'user_updated_at'     => $this->user_updated_at,
            'is_blocked'          => $this->is_blocked,
            'chat_room_details'   => $this->chat_room_details,
            'last_msg'            => $this->last_msg, // Assuming you have a relationship 'lastMessage'
            'unseen_count'        => $unseen_count,
            'time'                =>  (!empty($this->last_msg->chat_timestamp)) ? date('H:i A' , strtotime($this->last_msg->chat_timestamp)) : null
        ];
    }
}
