<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        !empty(@$this->reply->chat_message) ? my_cryption($this->reply->chat_message, 'd')  : NULL;
        return [
            'chat_id'           => (int)$this->chat_id,
            'chat_room_id'      => (int)$this->chat_room_id,
            'chat_from'         => $this->chat_from,
            'chat_to'           => $this->chat_to,
            'chat_seen'         => $this->chat_seen,
            'chat_message'      => !empty($this->chat_message) ? my_cryption($this->chat_message, 'd')  : NULL,
            'time'              => date('H:i A' , strtotime($this->chat_timestamp)),
            'chat_timestamp'    => $this->chat_timestamp,
            'chat_message_type' => $this->chat_message_type,
            'chat_attachment'   => $this->chat_attachment,
          //  'sender'            => $this->whenLoaded('sender'),
            'reply'             => $this->whenLoaded('reply') ? [ 'chat_id'               => @$this->reply->chat_id,
                                      'chat_reply_id'         => @$this->reply->chat_reply_id,
                                      'chat_message'          => !empty(@$this->reply->chat_message) ? my_cryption(@$this->reply->chat_message, 'd')  : NULL,
                                      'chat_attachment'       => @$this->reply->chat_attachment,
                                      'chat_message_type'     => @$this->reply->chat_message_type,
                                      'deleted_to'            => @$this->reply->deleted_to,
                                      'deleted_from'          => @$this->reply->deleted_from,
                                      'deleted_for_everyone'  => @$this->reply->deleted_for_everyone,
                                      'deleted_for'           => @$this->reply->deleted_for
                                    ] : null,
            "user_id"           => $this->sender->id,
            "user_firstname"    => $this->sender->first_name,
            "user_lastname"     => $this->sender->last_name,
            "user_avatar"       => $this->sender->image,
            'chat_favorite'     => $this->chat_favorite,
        ];

      //  return parent::toArray($request);
    }
}
