<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeenUserResource extends JsonResource
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
            'user_id'         => $this->user_id,
            'user_firstname'  => $this->user_firstname,
            'user_lastname'   => $this->user_lastname,
            'user_avatar'     =>  $baseUrl.'/'.'assets/images/users/avatar/'.$this->user_id.'/'.$this->user_avatar,
        ];
    }
}
