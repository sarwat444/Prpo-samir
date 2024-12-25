<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class SupportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $messages_count  = DB::table('client_chats')
                            ->select(DB::raw('ifnull(count(client_chat_id), 0) AS chat_count'))
                            ->where('client_chat_to', 0)
                            ->whereIn('client_chat_support', array(substr($this->u_type_permission_path, 17, 1)))
                            ->where('client_chat_seen', 0)
                            ->first();
        return [
            'u_type_permission_id'        => $this->u_type_permission_id,
            'u_type_permission_name'      => $this->u_type_permission_name,
            'u_type_permission_type'      => $this->u_type_permission_type,
            'u_type_permission_path'      => $this->u_type_permission_path,
            'u_type_permission_order'     => $this->u_type_permission_order,
            'u_type_permission_timestamp' => $this->u_type_permission_timestamp,
            'messages_count'              => $messages_count->chat_count??0
        ];
    }
}
