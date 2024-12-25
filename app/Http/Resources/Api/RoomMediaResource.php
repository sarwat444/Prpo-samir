<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'media'            =>   !empty($this->media) ? $this->media->map(function ($media) {
                                                            return [
                                                                'chat_room_id'        => $media->chat_room_id,
                                                                'chat_message'        => (!empty($media->chat_message)) ? my_cryption($media->chat_message , 'd') : null ,
                                                                'chat_attachment'     => $media->chat_attachment,
                                                                'chat_message_type'   => $media->chat_message_type,
                                                                'is_link'             => $media->is_link,
                                                            ];})
                                                        : null,
        ];
    }
}
