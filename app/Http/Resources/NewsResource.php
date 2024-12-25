<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'news_id'          => $this->news_id,
            'news_category'    => $this->news_category,
            'news_subcategory' => $this->news_subcategory,
            'news_title'       => $this->news_title,
            'news_description' => $this->news_description,
            'news_status'      => $this->news_status,
            'news_added_by'    => $this->news_added_by,
            'news_important_for' => array_map('trim', explode(',', $this->news_important_for)) ,
            'news_reason'      => $this->news_reason,
            'news_seen_by'     => $this->news_seen_by,
            'news_timestamp'   => $this->news_timestamp,
            'news_show'        => $this->news_show,
            'count_seen'       => $this->count_seen,
            'count_likes'      => $this->count_likes,
            'count_comments'   => $this->count_comments,
            'images' => array_map(function ($image) use ($baseUrl) {
                return str_replace('..', $baseUrl, $image);
            }, explode(',', $this->images)),
            'like_id'          => $this->like_id,
            'cat_image'        => $baseUrl.'/assets/images/news/'.$this->news_category.'.png'
        ];
    }
}
