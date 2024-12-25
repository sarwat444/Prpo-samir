<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chat_id'        => $this->chat_id,
            'chat_room_id'   => $this->chat_room_id,
            'chat_message'   => (!empty($this->chat_message)) ? my_cryption($this->chat_message, 'd') : null,
            'chat_timestamp' => $this->chat_timestamp
        ];
    }
}
