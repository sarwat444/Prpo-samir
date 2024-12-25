<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $table = "sub_tasks";
    protected $fillable = [
      'subtask_title',
      'task_id',
      'subtask_added_by',
      'subtask_user_id',
      'subtask_start_date',
      'subtask_due_date',
      'subtask_status',
        'tester'
    ];

    public function responsible(){
        return $this->belongsTo('App\Models\User' ,'subtask_user_id' , 'id');
    }
    public function task(){
        return $this->belongsTo('App\Models\Task' ,'task_id' , 'id');
    }
    public function data(){
      return $this->belongsTo('App\Models\Task' ,'task_id' , 'id');
  }
    public function added_by(){
     return $this->belongsTo('App\Models\User' ,'subtask_added_by' , 'id');
    }
    public function testerfun(){
        return $this->belongsTo('App\Models\User' ,'tester' , 'id');
    }
    public function history()
    {
      return $this->hasMany('App\Models\TaskHistory' ,'task_id','id');
    }



}
