<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    use HasFactory;
    protected $table = "taskshistory";
    protected $fillable = [
      'task_id',
      'user_id',
      'Time',
      'create_day'

    ];

    public function subtasks(){
        return $this->belongsTo('App\Models\SubTask' ,'task_id' , 'id');
    }


    public function responsiples(){
     return $this->belongsTo('App\Models\User' ,'user_id' , 'id');
    }


}
