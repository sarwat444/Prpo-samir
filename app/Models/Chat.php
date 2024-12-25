<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Chat extends Model
{
     use  HasFactory;

    protected $primaryKey       = 'chat_id';
    protected $guarded          = ['chat_id'];
    protected $table            = 'chat';
    public $timestamps          = false;

    public function sender(){
       return $this->belongsTo(User::class , 'chat_from' , 'id')->select('id' , 'first_name' , 'last_name' , 'image');
    }
    public function reciver()
    {
        return $this->belongsTo(User::class , 'chat_to' , 'id')->select('id' , 'first_name' , 'last_name' , 'image');
    }

    public function reply() {
        return $this->belongsTo(Chat::class , 'chat_reply_id' , 'chat_id')->select('chat_id' , 'chat_reply_id' , 'chat_message' , 'chat_attachment' , 'chat_message_type' , 'deleted_to' , 'deleted_from' , 'deleted_for_everyone' , 'deleted_for');
    }
}
