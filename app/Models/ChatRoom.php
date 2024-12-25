<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatRoom extends Model
{
    use HasFactory;
    protected $primaryKey       = 'chat_room_id';
    protected $guarded          = ['chat_room_id'];
    protected $table            = 'chat_rooms';
    public $timestamps          = false;

    public function last_msg() {
        return $this->belongsTo(Chat::class , 'chat_room_id' , 'chat_room_id')->where(['deleted_for_everyone' => 0 , 'deleted_to' => 0]);
    }

    public function media() {
        return $this->hasMany(Chat::class , 'chat_room_id' , 'chat_room_id')->select('chat_room_id' , 'chat_message' , 'chat_attachment' , 'chat_message_type' ,'is_link')->whereNotNull('chat_attachment')->orWhere('is_link' , 1);
    }

}
