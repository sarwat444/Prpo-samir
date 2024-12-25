<?php

namespace App\Http\Resources;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $chatRoom = ChatRoom::select('*')
        ->where('chat_room_creator', auth()->guard('api')->user()->id)
        ->where('chat_room_users', $this->id)
        ->where('chat_room_type', "Private")
        ->orWhere('chat_room_creator', $this->id)
        ->where('chat_room_users', auth()->guard('api')->user()->id)
        ->where('chat_room_type', "Private")
        ->first();


        return [
            'user_id'        =>  $this->id,
            'user_firstname' =>  $this->first_name,
            'user_lastname'  =>  $this->last_name,
            'user_avatar'    =>  'https://halalcheck-crm.de/assets/images/users/avatar/'. $this->id . '/' . $this->image,
            'room_id'        =>  @$chatRoom->chat_room_id
        ];
    }
}
