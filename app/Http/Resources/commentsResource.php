<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class commentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseUrl = 'https://halalcheck-crm.de';
        return [
            'comment_id'        => $this->comment_id,
            'comment_text'      => $this->comment_text,
            'comment_news_id'   => $this->comment_news_id,
            'comment_user_id'   => $this->comment_user_id,
            'comment_timestamp' => $this->comment_timestamp,
            'user_firstname'    => $this->user_firstname,
            'user_avatar'       => $baseUrl.'/assets/images/users/avatar/'. $this->comment_user_id.'/'. $this->user_avatar,
        ];
    }
}
