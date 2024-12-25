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
class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

     public $user_id;
     public $desc;
     public $taskid;
     public $catid;
     public $username;
     public $userimage;
     public $data;
     public $time;

    public function __construct($data = [])
    {

        // dd($data);
        $this->user_id = $data['log_user_id'];
        $this->desc = $data['log_desc'];
        $this->taskid = $data['log_task_id'];
        $this->catid = $data['log_cat_id'];
        $this->username = $data['user_name'];
        $this->userimage = $data['user_image'];
        $this->date = date("Y-m-d", strtotime(Carbon::now()));
        $this->time = date("h:i A", strtotime(Carbon::now()));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */



     public function broadcastOn()
    {
       return ['my-channel'];
    }
}
