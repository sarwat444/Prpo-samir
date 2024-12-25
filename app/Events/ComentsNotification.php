<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ComentsNotification implements ShouldBroadcast
{


    use Dispatchable, InteractsWithSockets, SerializesModels;

     public  $comment_id ;
      public  $task_id;
     public  $added_by;
     public  $comment_author;
     public  $user_image ;
     public  $date ;
     public  $time ;

    public function __construct($data = [])
    {
        $this->comment_id =   $data['comment_id'];
        $this->added_by =   $data['added_by'];
        $this->task_id =   $data['task_id'];
        $this->comment_author =   $data['comment_author'];
        $this->user_image     =  $data['user_image'];
        $this->date = date("d.m.Y", strtotime(Carbon::now()));
        $this->time = date("h:i A", strtotime(Carbon::now()));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
     
   
   
     public function broadcastOn()
    {
            return ['replay_channel'];
    }
}
